<?php

namespace App\Livewire\Chatbot;

use Livewire\Component;
use Prism\Prism\Facades\Prism;
use Prism\Prism\Enums\Provider;
use Prism\Prism\ValueObjects\Messages\UserMessage;
use Prism\Prism\ValueObjects\Messages\AssistantMessage;
use App\Models\Pet;
use App\Models\Vaccine;
use Throwable;

class Index extends Component
{
    public array $messages = [];
    public string $input = '';
    public bool $isThinking = false;
    public ?string $error = null;

    public function sendMessage(): void
    {
        $input = trim($this->input);
        if ($input === '' || $this->isThinking) {
            return;
        }

        $this->error = null;
        $this->messages[] = [
            'role'    => 'user',
            'content' => $input,
            'time'    => now()->format('H:i'),
        ];

        $this->input      = '';
        $this->isThinking = true;

        try {
            $prismMessages = [];
            foreach ($this->messages as $msg) {
                if ($msg['role'] === 'user') {
                    $prismMessages[] = new UserMessage($msg['content']);
                } elseif ($msg['role'] === 'assistant') {
                    $prismMessages[] = new AssistantMessage($msg['content']);
                }
            }

            $response = Prism::text()
                ->using(Provider::Groq, 'llama-3.3-70b-versatile')
                ->withSystemPrompt($this->buildSystemPrompt())
                ->withMessages($prismMessages)
                ->withMaxTokens(1024)
                ->generate();

            $this->messages[] = [
                'role'    => 'assistant',
                'content' => $response->text,
                'time'    => now()->format('H:i'),
            ];
        } catch (Throwable $e) {
            $msg = $e->getMessage();
            if (str_contains($msg, 'rate limit') || str_contains($msg, 'quota')) {
                $this->error = 'Terlalu banyak permintaan. Tunggu beberapa detik lalu coba lagi.';
            } elseif (str_contains($msg, 'API key') || str_contains($msg, 'api_key')) {
                $this->error = 'API key tidak valid. Periksa GROQ_API_KEY di .env.';
            } else {
                $this->error = 'Gagal mendapatkan respons: ' . $msg;
            }
        }

        $this->isThinking = false;
    }

    private function buildSystemPrompt(): string
    {
        $pets = Pet::with(['vaccines' => fn($q) => $q->orderBy('vaccine_date', 'desc')])
            ->orderBy('name')
            ->get();

        $petContext = '';

        if ($pets->isEmpty()) {
            $petContext = "\n\nDATA HEWAN: Belum ada hewan yang terdaftar di sistem.";
        } else {
            $lines = [];
            foreach ($pets as $pet) {
                $line  = "- {$pet->name} ({$pet->type}";
                $line .= $pet->breed ? ", ras: {$pet->breed}" : '';
                $line .= $pet->age   ? ", umur: {$pet->age} tahun" : '';
                $line .= $pet->weight ? ", berat: {$pet->weight} kg" : '';
                $line .= ", kelamin: " . ($pet->gender === 'male' ? 'Jantan' : 'Betina');
                $line .= ", status: " . ($pet->is_active ? 'Aktif' : 'Tidak Aktif');

                if ($pet->flea_medicine_date) {
                    $days  = (int) $pet->flea_medicine_date->diffInDays(now());
                    $flag  = $days > 90 ? ' (PERLU DIPERBARUI, sudah ' . $days . ' hari lalu)' : ' (' . $days . ' hari lalu)';
                    $line .= " | Obat kutu terakhir: " . $pet->flea_medicine_date->format('d M Y') . $flag;
                } else {
                    $line .= " | Obat kutu: belum pernah dicatat";
                }

                if ($pet->deworming_date) {
                    $days  = (int) $pet->deworming_date->diffInDays(now());
                    $flag  = $days > 90 ? ' (PERLU DIPERBARUI, sudah ' . $days . ' hari lalu)' : ' (' . $days . ' hari lalu)';
                    $line .= " | Obat cacing terakhir: " . $pet->deworming_date->format('d M Y') . $flag;
                } else {
                    $line .= " | Obat cacing: belum pernah dicatat";
                }

                if ($pet->vaccines->isNotEmpty()) {
                    $latest = $pet->vaccines->first();
                    $line  .= " | Vaksin terakhir: {$latest->vaccine_name} ({$latest->vaccine_date->format('d M Y')})";

                    if ($latest->next_vaccine_date) {
                        $next   = $latest->next_vaccine_date;
                        $status = $next->isPast() ? 'TERLAMBAT' : 'jadwal ' . $next->format('d M Y');
                        $line  .= ", vaksin berikutnya: {$status}";
                    }

                    $line .= " | Total vaksin: {$pet->vaccines->count()}";
                } else {
                    $line .= " | Belum ada riwayat vaksin";
                }

                $lines[] = $line;
            }

            $total  = $pets->count();
            $aktif  = $pets->where('is_active', true)->count();
            $petContext = "\n\nDATA HEWAN PELIHARAAN DI SISTEM (total: {$total}, aktif: {$aktif}):\n" . implode("\n", $lines);
        }

        return <<<PROMPT
Kamu adalah asisten ahli hewan peliharaan bernama "PetBot" untuk aplikasi manajemen hewan peliharaan.

Kamu menjawab dua jenis pertanyaan:
1. Pertanyaan umum seputar hewan (perawatan, kesehatan, makanan, perilaku, vaksinasi, dll.)
2. Pertanyaan tentang data hewan yang terdaftar di sistem ini (lihat DATA di bawah)

Jika ditanya tentang hewan tertentu yang ada di data, berikan informasi spesifik dari data tersebut plus saran perawatan yang relevan.
Jika ditanya hal di luar topik hewan, tolak dengan sopan dan arahkan ke topik hewan.
Jawab dalam bahasa yang sama dengan pertanyaan pengguna (Indonesia atau Inggris).
Gunakan format yang ramah dan mudah dipahami. Boleh gunakan emoji secukupnya.
{$petContext}
PROMPT;
    }

    public function clearChat(): void
    {
        $this->messages   = [];
        $this->error      = null;
        $this->isThinking = false;
    }

    public function render()
    {
        return view('livewire.chatbot.index')
            ->layout('layouts.app', ['title' => 'Chatbot Hewan', 'fullHeight' => true]);
    }
}
