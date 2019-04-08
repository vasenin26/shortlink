<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShortLink extends Model
{

    protected $fillable = ['origin'];

    private static $availableSymbols = ['~', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-', '_', '.'];

    public function getLinkCode(){

        $base = count(self::$availableSymbols);
        $result = $this->id;
        $code = [];

        while($result >= $base){

            $rest = $result % $base;
            $code[] = self::$availableSymbols[$rest];

            $result = intdiv($result, $base);

        }

        $code[] = self::$availableSymbols[$result];

        return join($code);
    }

    public static function findByCode($code){

        $id = 0;

        for($i = 0; $i < strlen($code); $i++){

            $position = array_search($code[$i], self::$availableSymbols);

            if($position === false){
                throw (new ModelNotFoundException)->setModel(
                    self::class, $code
                );
            }

            $id += $position * pow(count(self::$availableSymbols), $i);

        }

        return self::findOrFail($id);

    }
}
