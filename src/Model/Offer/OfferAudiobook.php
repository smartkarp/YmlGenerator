<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer;

final class OfferAudiobook extends AbstractOffer
{
    use OfferBookTrait;

    private const TYPE = 'audiobook';

    private ?string $format = null;

    private ?string $performanceType = null;

    private ?string $performedBy = null;

    private ?string $recordingLength = null;

    private ?string $storage = null;

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(?string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getPerformanceType(): ?string
    {
        return $this->performanceType;
    }

    public function setPerformanceType(?string $performanceType): self
    {
        $this->performanceType = $performanceType;

        return $this;
    }

    public function getPerformedBy(): ?string
    {
        return $this->performedBy;
    }

    public function setPerformedBy(?string $performedBy): self
    {
        $this->performedBy = $performedBy;

        return $this;
    }

    public function getRecordingLength(): ?string
    {
        return $this->recordingLength;
    }

    public function setRecordingLength(?string $recordingLength): self
    {
        $this->recordingLength = $recordingLength;

        return $this;
    }

    public function getStorage(): ?string
    {
        return $this->storage;
    }

    public function setStorage(?string $storage): self
    {
        $this->storage = $storage;

        return $this;
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    protected function getOptions(): array
    {
        $data = $this->getTraitOptions();

        if ($this->getPerformedBy() !== null) {
            $data['performed_by'] = $this->getPerformedBy();
        }

        if ($this->getPerformanceType() !== null) {
            $data['performance_type'] = $this->getPerformanceType();
        }

        if ($this->getStorage() !== null) {
            $data['storage'] = $this->getStorage();
        }

        if ($this->getFormat() !== null) {
            $data['format'] = $this->getFormat();
        }

        if ($this->getRecordingLength() !== null) {
            $data['recording_length'] = $this->getRecordingLength();
        }

        return $data;
    }
}
