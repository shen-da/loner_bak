<?php

declare(strict_types=1);

namespace App\Console;

use Loner\Console\Command\Command;
use Loner\Console\Helper\Questioner;
use Loner\Console\Input\Input;
use Loner\Console\Output\Output;
use Loner\Console\Question\ChoiceQuestion;
use Loner\Console\Question\ConfirmationQuestion;

/**
 * 演示命令
 *
 * @package App\Console
 */
class DemoCommand extends Command
{
    /**
     * @inheritDoc
     */
    public static function getDefaultName(): string
    {
        return 'demo';
    }

    /**
     * @inheritDoc
     */
    public static function getDefaultDescription(): string
    {
        return 'This is a demo command';
    }

    /**
     * @inheritDoc
     */
    public function getNamespace(): string
    {
        return 'x';
    }

    /**
     * @inheritDoc
     */
    public function getDefinitions(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function run(Input $input, Output $output): int
    {
        $questioner = new Questioner($output);

        $question = new ChoiceQuestion(
            'Please select your favorite color (defaults to red)',
            array('xxxxxx' => 'red', 'yx' => 'blue', 'yellow', 'blue'),
            'yx'
        );

        $question->setMultiselect(true);
        $question->setMaxAttempts(3);

        $answer = $questioner->ask($question);

        var_dump($answer);

        return 0;
    }

    /**
     * 克隆输入流，以便在不影响其他实例的情况下对同一流的一个实例执行操作
     *
     * @param resource $inputStream
     * @return resource|null
     */
    private static function cloneInputStream($inputStream)
    {
        $streamMetaData = stream_get_meta_data($inputStream);

        if (!isset($streamMetaData['uri'])) {
            return null;
        }

        $uri = $streamMetaData['uri'];
        $seekable = $streamMetaData['seekable'] ?? false;
        $mode = $streamMetaData['mode'] ?? 'rb';

        $cloneStream = fopen($uri, $mode);

        // 对于可查找和可写流，将所有相同的数据添加到克隆流，然后查找到相同的偏移量
        if (true === $seekable && !in_array($mode, ['r', 'rb', 'rt'])) {
            $offset = ftell($inputStream);
            rewind($inputStream);
            stream_copy_to_stream($inputStream, $cloneStream);
            fseek($inputStream, $offset);
            fseek($cloneStream, $offset);
        }

        return $cloneStream;
    }
}
