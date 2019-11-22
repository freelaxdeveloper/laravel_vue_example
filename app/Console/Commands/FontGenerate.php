<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Font;

class FontGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FontGenerate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Сканирует шрифты в категории resources/assets/fonts, создает файл resources/assets/sass/_font.scss со стилями. Так же обновляет данные шрифтов в базе данных "fonts"';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Старт');
        $files = glob(base_path('resources/assets/fonts') . '/*');
        $count = count($files);
        $bar = $this->output->createProgressBar($count);
        $this->info("Найдено {$count} шрифтов");
        $text = '';
        for ($i = 0; $i < count($files); $i++) {
            $file = basename($files[$i], '.ttf');
            $name = mb_strtolower($file);
            $text .= <<<HTML
                @font-face {
                    font-family: '{$name}';
                    src: url('../fonts/{$file}.ttf');
                }\n
HTML;
        }
        $fonts = [];
        for ($i = 0; $i < count($files); $i++) {
            $file = basename($files[$i], '.ttf');
            $name = mb_strtolower($file);

            $fonts[] = [
                'name' => $name,
                'class' => "font-{$name}",
                'path' => base_path("resources/assets/fonts/{$file}.ttf"),
            ];

            $text .= <<<HTML
                .font-{$name} {
                    font-family: '{$name}';
                }\n
HTML;
            if ($count - $i <= 3) {
                sleep(1);
            }
            $bar->advance();
        }
        $bar->finish();
        $this->info('');

        $f = fopen(base_path('resources/assets/sass/_font.scss'), 'w+');
        fwrite($f, $text);
        fclose($f);
        // file_put_contents(base_path('resources/assets/sass/_font.scss'), $text);

        $this->info('Сохранен файл _font.scss');
        Font::truncate();
        $this->info('Очищена таблица fonts в базе данных');
        Font::insert($fonts);
        $this->info('Данные записаны в базу данных');
        $this->info('Готово');
    }
}
