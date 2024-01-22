<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

/**
 *
 */
class fileImportControllerold extends Controller
{
    /**
     * Method to import the log file and process the data
     *
     * @return array
     */
    public function processarLog(): array
    {
        {
            $relativePath = "/home/maicon/code/testecriar/storage/logs/race.log";

            $lines = file($relativePath, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

            array_shift($lines);
            $lines = str_replace('– ', '', $lines);
            $results = [];

            // Flag to indicate whether the race was finished by the first driver
            $raceFinished = false;

            // Loop to process each log line
            foreach ($lines as $line) {
                list($horaVolta, $codigo, $name, $volta, $tempoVolta, $velocidadeMedia) = explode(' ', $line);

                // Initialize pilot if not already in array
                if (!isset($results[$codigo])) {
                    $results[$codigo] = [
                        'codigo' => $codigo,
                        'nomePiloto' => $name,
                        'voltasCompletadas' => '',
                        'tempoTotal' => 0,
                        'posicaoFinal' => 0,
                        'voltas' => []
                    ];
                }

                // Adds current lap information to the lap array
                $results[$codigo]['Voltas'][] = [
                    'numero' => $volta,
                    'horavolta' => $horaVolta,
                    'tempoVolta' => $tempoVolta,
                    'valocidadeMedia' => $velocidadeMedia,
                ];

                // Checks if the time is valid && Updates rider information
                if ($tempoVolta >= null) {
                    $results[$codigo]['voltasCompletadas'] = max($results[$codigo]['voltasCompletadas'], (int)$volta);
                    $results[$codigo]['tempoTotal'] += $this->tempoParaSegundos($tempoVolta);
                }

                // Checks if the race was finished by the first driver
                if ($results[$codigo]['voltasCompletadas'] === 4 && !$raceFinished) {
                    $raceFinished = true;
                }
            }
            // Sorts results based on number of laps completed and total time
            usort($results, function ($a, $b) {
                if ($a['voltasCompletadas'] === $b['voltasCompletadas']) {
                    return $a['tempoTotal'] <=> $b['tempoTotal'];
                }

                return $b['voltasCompletadas'] <=> $a['voltasCompletadas'];
            });

            $posicaoChegada = 1;

            foreach ($results as &$info) {
                $info['Posicao_Chegada'] = $posicaoChegada++;
            }
        }

        return $results;
    }

    /**
     * Method to calculate the total time in seconds using the format mm:ss.mmm
     *
     * @param $tempo
     * @return float|int
     */
    public function tempoParaSegundos($tempo): float|int
    {
        $tempoPartes = explode(':', $tempo);

        $minutos = isset($tempoPartes[0]) ? (int)$tempoPartes[0] : 0;

        $segundosPartes = explode('.', $tempoPartes[1]);

        $segundos = isset($segundosPartes[0]) ? (int)$segundosPartes[0] : 0;
        $milissegundos = isset($segundosPartes[1]) ? (int)$segundosPartes[1] : 0;

        return ($minutos * 60 + $segundos) * 1000 + $milissegundos;
    }
}
