<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Service;

final class Settings
{
    private string $encoding = 'windows-1251';

    /**
     * Indent string in xml file. False or null means no indent;
     */
    private string $indentString = "\t";

    /**
     * Output file name. If null 'php://output' is used.
     */
    private ?string $outputFile = null;

    /**
     * If true Generator will return generated YML string.
     * Not recommended to use this for big catalogs because of heavy memory usage.
     */
    private bool $returnResultYMLString = false;

    public function getEncoding(): string
    {
        return $this->encoding;
    }

    public function setEncoding(string $encoding): self
    {
        $this->encoding = $encoding;

        return $this;
    }

    public function getIndentString(): string
    {
        return $this->indentString;
    }

    public function setIndentString(string $indentString): self
    {
        $this->indentString = $indentString;

        return $this;
    }

    public function getOutputFile(): ?string
    {
        return $this->outputFile;
    }

    public function setOutputFile(string $outputFile): self
    {
        $this->outputFile = $outputFile;

        return $this;
    }

    public function getReturnResultYMLString(): bool
    {
        return $this->returnResultYMLString;
    }

    public function setReturnResultYMLString(bool $returnResultYMLString): self
    {
        $this->returnResultYMLString = $returnResultYMLString;

        return $this;
    }
}
