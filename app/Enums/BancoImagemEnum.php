<?php 

namespace App\Enums;

enum BancoImagemEnum: int
{
    case istock = 0;
    case shutterstock = 1;
    case freepik = 2;
    case envato = 3; 
    case motionarray = 4;
    case graphipear = 5;
    case flaticon = 6;
    case istock_vector = 7;
    case shutterstock_vector = 8;
    case freepik_vector = 9;
    case freepik_mockup = 10;

     // Método para retornar informações extras
    public function getDescription(): string
    {
        return match($this) {
            self::istock => 'istock',
            self::shutterstock => 'shutterstock',
            self::freepik => 'freepik',
            self::envato => 'envato',
            self::motionarray => 'motionarray',
        };
    }

    public function getVideoCondition(): string
    {
        return match($this) {
            self::istock => false,
            self::shutterstock => false,
            self::freepik => true,
            self::envato => true, 
            self::motionarray => true,
        };
    }

    public function getVideoDescription(): string
    {
        return match($this) {
            self::istock => '/viasddeo/',
            self::shutterstock => '/video/',
            self::freepik => '',
            self::envato => '',
        };
    } 

    public function getUrl(): string
    {
        return match($this) {
            self::istock => 'https://www.istockphoto.com',
            self::shutterstock => 'https://www.shutterstock.com',
            self::freepik => 'https://www.freepik.com',
            self::envato => 'https://www.elements.envato.com',
            self::motionarray => 'https://motionarray.com',
        };
    } 

    public function getStockParam(): string
    {
        return match($this) {
            self::istock => 'istock',
            self::shutterstock => 'shutterstock',
            self::freepik => 'freepik',
            self::envato => 'envato',
            self::motionarray => 'motionarray',
        };
    } 
    public function getStockRegex(): string{
        return match($this){
            self::istock => '/foto\/(.*)-gm(\d+)/',
            self::istock_vector => '/vetor\/(.*)-gm(\d+)/',
            self::shutterstock => '/image-photo\/(.*)-(\d+)/',
            self::shutterstock_vector => '/image-vector\/(.*)-(\d+)/',
            self::freepik => '/-premium\/(.*?)_/',
        };
    }

    //TODO: Ja vou avisando que o shutter vai salvar as imagens como vector pois o código valida um trecho da url
    // para determinar se é imagem ou não
    public function getStockType(): string{
        return match($this){
            self::istock => 'image',
            self::istock_vector => 'vector',
            self::shutterstock => 'image',
            self::shutterstock_vector => 'vector',
            self::freepik => 'image',
            self::freepik_vector => 'vector',
            self::freepik_mockup => 'vector',
        };
    }

    public static function fromName(string $name)
    {
        return match ($name) {
            'istock' => self::istock,
            'shutterstock' => self::shutterstock,
            'freepik' => self::freepik,
            'envato' => self::envato,
            'motionarray' => self::motionarray,
            'graphipear' => self::graphipear,
            'flaticon' => self::flaticon,
            'istock_vector' => self::istock_vector,
            'shutterstock_vector' => self::shutterstock_vector,
            'freepik_vector' => self::freepik_vector,
            'freepik_mockup' => self::freepik_mockup, 
            default => null,
        };
    }
} 