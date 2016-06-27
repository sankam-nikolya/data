<?php

namespace atk4\data;

class Field_SQL extends Field implements \atk4\dsql\Expressionable {

    public $actual = null;

    /**
     * When field is used as expression, this method will be called
     */
    function getDSQLExpression($expression)
    {
        if (isset($this->owner->persistence_data['use_table_prefixes'])) {
            if ($this->actual) {
                return $expression->expr('{}.{} {}', [
                    $this->relation ? $this->relation->short_name 
                    : ($this->owner->table_alias ?: $this->owner->table),
                    $this->actual, 
                    $this->short_name
                ]);
            } else {
                return $expression->expr('{}.{}', [
                    $this->relation ? $this->relation->short_name 
                    : ($this->owner->table_alias ?: $this->owner->table),
                    $this->short_name
                ]);
            }
        } else {
            // relations set flag use_table_prefixes, so no need to check them here
            if ($this->actual) {
                return $expression->expr('{} {}', [
                    $this->actual, 
                    $this->short_name
                ]);
            } else {
                return $expression->expr('{}', [
                    $this->short_name
                ]);
            }
        }
    }
}
