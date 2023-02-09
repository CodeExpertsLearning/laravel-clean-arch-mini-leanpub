<?php

namespace MiniLeanpub\Infrastructure\Service\BookConverter;

use League\CommonMark\CommonMarkConverter;

class BookConverterService implements BookConverterInterface
{
    public function __construct(private array $bookFiles, private string $pathOutput)
    {
    }

    public function makeConversion()
    {
        $converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        $htmlPages = [];

        foreach ($this->bookFiles as $key => $book) {
            $content = file_get_contents($book);

            $htmlPages['page-' . $key] = (string) $converter->convert($content);
        }

        return (new BookPDFMaker($htmlPages))->setPathOutput($this->pathOutput)->make();
    }
}
