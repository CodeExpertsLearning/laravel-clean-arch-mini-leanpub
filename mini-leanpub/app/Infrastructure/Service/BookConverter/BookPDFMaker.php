<?php

namespace MiniLeanpub\Infrastructure\Service\BookConverter;;

use TCPDF;

class BookPDFMaker
{
    private string $pathOutput;

    public function __construct(private array $bookHtmlPages)
    {
    }

    public function setPathOutput(string $path)
    {
        $this->pathOutput = $path;
        return $this;
    }

    public function make(): string
    {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('CUSTOMER');
        $pdf->SetTitle('Titulo Livro...');
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetMargins(10, 10, 10);
        $pdf->setFontSubsetting(true);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, 10);

        foreach ($this->bookHtmlPages as $page) {
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(false, 0);

            $pdf->writeHTML($page, true, false, true, false, '');
        }

        $pdf->Output($this->pathOutput . '/book.pdf', 'F');

        return $this->pathOutput . '/book.pdf';
    }
}
