<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShortLink extends Model
{

    protected $fillable = ['origin'];

    private $availableSymbols = ['A', 'a', 'b', 'B'];

    public function getLinkCode(){

        $base = count($this->availableSymbols);
        $result = $this->id;
        $code = [];

        while($result > $base){

            $rest = $result % $base;
            $code[] = $this->availableSymbols[$rest];

            $result = intdiv($result - 1, $base);

        }

        $code[] = $this->availableSymbols[$result - 1];

        return join($code);
    }
}
