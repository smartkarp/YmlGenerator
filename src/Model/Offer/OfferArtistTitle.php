<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer;

use Smartkarp\Bundle\YmlGeneratorBundle\Enum\CurrencyEnum;

final class OfferArtistTitle extends AbstractOffer
{
    private const TYPE = 'artist.title';

    private ?string $artist = null;

    private ?string $media = null;

    private string $title;

    private ?int $year = null;

    public function __construct(
        int          $categoryId,
        CurrencyEnum $currencyId,
        string       $id,
        string       $name,
        float        $price,
        string       $title,
        string       $url
    ) {
        parent::__construct($categoryId, $currencyId, $id, $name, $price, $url);

        $this->title = $title;
    }

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(string $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getMedia(): ?string
    {
        return $this->media;
    }

    public function setMedia(string $media): self
    {
        $this->media = $media;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    protected function getOptions(): array
    {
        $data = [
            'title' => $this->getTitle(),
        ];

        if ($this->getArtist() !== null) {
            $data['artist'] = $this->getArtist();
        }

        if ($this->getYear() !== null) {
            $data['year'] = $this->getYear();
        }

        if ($this->getMedia() !== null) {
            $data['media'] = $this->getMedia();
        }

        return $data;
    }
}
