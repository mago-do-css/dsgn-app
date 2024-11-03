<?php

namespace App\Enums;

enum StockTypeEnum: int
{
    case image = 0;
    case vector = 1;
    case mockup = 2; 
    case video = 3;
    case icon = 4;
    case psd = 5; 

    public function getStockTypeDescription(): string{
        return match($this){ 
            self::image => 'imagem',
            self::vector => 'vetor',
            self::mockup => 'mockup',
            self::video => 'vídeo',
            self::psd => 'arquivo psd',
            self::icon => 'ícone', 
        };
    }

     public static function fromName(string $name): int
    {
        return match($name) {
            'image' => self::image->value,
            'vector' => self::vector->value,
            'mockup' => self::mockup->value,
            'video' => self::video->value,
            'icon' => self::icon->value,
            'psd' => self::psd->value,
            default => false,
        };
    }
}
