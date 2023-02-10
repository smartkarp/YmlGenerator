<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer;

trait OfferBookTrait
{
    private ?string $ISBN = null;

    private ?string $author = null;

    private ?string $language = null;

    private ?int $part = null;

    private string $publisher;

    private ?string $series = null;

    private ?string $tableOfContents = null;

    private ?int $volume = null;

    private ?int $year = null;

    public function __construct(string $publisher) {
        $this->publisher = $publisher;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getISBN(): ?string
    {
        return $this->ISBN;
    }

    public function setISBN(?string $ISBN): self
    {
        $this->ISBN = $ISBN;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getPart(): ?int
    {
        return $this->part;
    }

    public function setPart(?int $part): self
    {
        $this->part = $part;

        return $this;
    }

    public function getPublisher(): string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getSeries(): ?string
    {
        return $this->series;
    }

    public function setSeries(?string $series): self
    {
        $this->series = $series;

        return $this;
    }

    public function getTableOfContents(): ?string
    {
        return $this->tableOfContents;
    }

    public function setTableOfContents(?string $tableOfContents): self
    {
        $this->tableOfContents = $tableOfContents;

        return $this;
    }

    public function getVolume(): ?int
    {
        return $this->volume;
    }

    public function setVolume(?int $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }

    private function getTraitOptions(): array
    {
        $data = [
            'name'      => $this->getName(),
            'publisher' => $this->getPublisher(),
        ];

        if ($this->getAuthor() !== null) {
            $data['author'] = $this->getAuthor();
        }

        if ($this->getSeries() !== null) {
            $data['series'] = $this->getSeries();
        }

        if ($this->getYear() !== null) {
            $data['year'] = $this->getYear();
        }

        if ($this->getISBN() !== null) {
            $data['ISBN'] = $this->getISBN();
        }

        if ($this->getVolume() !== null) {
            $data['volume'] = $this->getVolume();
        }

        if ($this->getPart() !== null) {
            $data['part'] = $this->getPart();
        }

        if ($this->getLanguage() !== null) {
            $data['language'] = $this->getLanguage();
        }

        if ($this->getTableOfContents() !== null) {
            $data['table_of_contents'] = $this->getTableOfContents();
        }

        return $data;
    }
}
