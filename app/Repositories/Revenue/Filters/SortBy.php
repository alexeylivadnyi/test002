<?php


namespace App\Repositories\Revenue\Filters;


use App\Repositories\FilterContract;
use Illuminate\Database\Eloquent\Builder;

class SortBy implements FilterContract
{
    protected array $fields;
    protected array $directions;

    /**
     * WithSort constructor.
     * @param array $fields
     * @param array $directions
     */
    public function __construct (array $fields, array $directions)
    {
        $this->fields = $fields;
        $this->directions = $directions;
    }

    /**
     * @inheritDoc
     */
    public function apply (Builder $query): void
    {
        if (count($this->fields)) {
            $orderString = '';
            $lastIndex = count($this->fields) - 1;
            if (in_array('product', $this->fields)) {
                $query->join('products', 'products.id', '=', 'revenues.product_id');
            }
            if (in_array('client', $this->fields)) {
                $query->join('clients', 'clients.id', '=', 'revenues.client_id');
            }
            foreach ($this->fields as $index => $field) {
                $direction = !!intval($this->directions[$index]) ? 'desc' : 'asc';
                $fieldName = $field;
                switch ($field) {
                    case 'client':
                        $fieldName = 'clients.name';
                        break;
                    case 'product':
                        $fieldName = 'products.name';
                        break;
                    case 'id':
                        $fieldName = 'revenues.id';
                        break;
                }
                $orderString .= "{$fieldName} {$direction}" . ($index === $lastIndex ? '' : ', ');
            }
            $query->orderByRaw($orderString);
        }
    }
}
