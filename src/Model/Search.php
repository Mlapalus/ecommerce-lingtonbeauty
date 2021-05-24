<?php 

namespace App\Model;

use App\Entity\Category;

class Search
{
    /**
     * @var string
     */
    private ?string $name;

    /**
     *
     * @var Category[]
     */
    private $categories;

    public function __construct()
    {
        $this->name = "";
        $this->categories = [];
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name)
    {
        $this->name = $name;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories)
    {
        $this->categories = $categories;
    }

}
