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
} 