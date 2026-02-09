<?php 

namespace App\DataTransferObjects\PostMeta\Response;

class IndexPostMetaDTO
{
    /**
     * Data Transfer Object for representing post meta information in an index response.
     *
     * @param string $key The key of the post meta.
     * @param string $value The value associated with the post meta key.
     */
    public function __construct(
        public string $key,
        public string $value,
    ) {}

    /**
     * Creates a new instance of the class from an associative array.
     *
     * @param array $data Associative array containing 'key' and 'value' keys.
     * @return self Returns an instance of the class populated with the provided data.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            key: $data['key'],
            value: $data['value'],
        );
    }

    /**
     * Converts the IndexPostMetaDTO object properties to an associative array.
     *
     * @return array{
     *     key: string,
     *     value: string
     * }
     * Returns an array containing the post meta's key and value.
     */
    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'value' => $this->value,
        ];
    }
}