<?php

namespace App\Infrastructure\ProviderImpl;

use App\Domain\ProviderInterface\VisitorIncrementProviderInterface;

final readonly class VisitorIncrementTextProvider implements VisitorIncrementProviderInterface
{
    private string $filePath;

    public function __construct(string $filePath = null)
    {
        // Stockage par défaut dans var/share/visits_count.txt
        $projectDir = dirname(__DIR__, 3);
        $defaultPath = $projectDir . '/var/share/visits_count.txt';
        $this->filePath = $filePath ?? $defaultPath;
    }

    /**
     * Incrémente le compteur et retourne la nouvelle valeur.
     */
    public function increment(): void
    {
        $this->ensureDirectory();

        $fp = fopen($this->filePath, 'c+');
        if ($fp === false) {
            // En cas d'échec d'ouverture, retourner 0 (pas d'exception pour rester non bloquant)
            return;
        }

        try {
            // Verrou exclusif
            if (!flock($fp, LOCK_EX)) {
                return;
            }

            // Se placer au début
            rewind($fp);
            $contents = stream_get_contents($fp) ?: '';
            $current = is_numeric(trim($contents)) ? (int)trim($contents) : 0;

            $current++;

            // Écrire la nouvelle valeur
            ftruncate($fp, 0);
            rewind($fp);
            fwrite($fp, (string)$current);
            fflush($fp);

            // Libérer le verrou
            flock($fp, LOCK_UN);

            return;
        } finally {
            fclose($fp);
        }
    }

    private function ensureDirectory(): void
    {
        $dir = dirname($this->filePath);
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
    }

    /**
     * Retourne la valeur actuelle sans incrémenter.
     */
    public function get(): int
    {
        if (!file_exists($this->filePath)) {
            return 0;
        }
        $data = @file_get_contents($this->filePath);
        return is_numeric(trim((string)$data)) ? (int)trim((string)$data) : 0;
    }
}
