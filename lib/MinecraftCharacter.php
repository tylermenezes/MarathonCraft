<?php
class MinecraftCharacter{
    public $name;
    public $body;

    private $image;
    private $imageInfo;
    private static $transColorA = array();

    public function __construct($name){
        $this->name = $name;
    }

    public function load($uri = null){
        $this->image = self::LoadPng(($uri? $uri : "http://www.minecraft.net/skin/" . $this->name . ".png"));
        $this->imageInfo = array(64, 32);

        $usedColors = array();

        // Find unused color and set it as transparent. (PHP GD hack.)
        for($x = 0; $x < imagesx($this->image); $x++){
            for($y = 0; $y < imagesy($this->image); $y++){
                $rgb = imagecolorat($this->image, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                $usedColors[$r][$g][$b] = 1;
            }
        }

        $use_r = 0;
        $use_b = 0;
        $use_g = 0;

        // The image is 2048 pixels. This is a pidgeonhole problem, so we
        // just check n>2048 possibilities and we will have an unused color.
        // 
        // Also, this is almost always just (0,1,0), because no one uses
        // not-quite-black ;D
        for($r = 0; $r < 9; $r++){
            if(!isset($usedColors[$r])){
                $use_r = $r;
                break;
            }

            for($g = 0; $g < 255; $g++){
                if(!isset($usedColors[$r][$g])){
                    $use_g = $g;
                    break(2);
                }
            }
        }

        self::$transColorA = array($use_r, $use_g, $use_b);
        imagecolortransparent($this->image, self::getTransColor($this->image));

        $this->body = new Body();
        $this->body->head = new Part($this->all()->getBlocks(0,0,8,4), "head");
        $this->body->hat = new Part($this->all()->getBlocks(9,0,8,4), "head");
        $this->body->legs = new Part($this->all()->getBlocks(0,4,4,4), "limb");
        $this->body->torso = new Part($this->all()->getBlocks(4,4,6,4), "torso");
        $this->body->arms = new Part($this->all()->getBlocks(10,4,4,4), "limb");

    }

    public static function getTransColor($image){
        return imagecolorallocate($image, self::$transColorA[0], self::$transColorA[1], self::$transColorA[2]);
    }

    public function all(){
        return new Image($this->image);
    }

    public function profile(){
        $canvas = imagecreatetruecolor(4*4, 8*4);
        $r = imagecolorallocate($canvas, 255, 0, 0);
        imagefill($canvas, 0, 0, self::getTransColor($canvas));
        imagecolortransparent($canvas, self::getTransColor($canvas));

        $canvas = new Image($canvas);
        $canvas->insertBlocks($this->body->head->front, 1, 0);
        $canvas->insertBlocks($this->body->arms->front, 0, 2);
        $canvas->insertBlocks($this->body->torso->front, 1, 2);
        $canvas->insertBlocks($this->body->arms->front, 3, 2);
        $canvas->insertBlocks($this->body->legs->front, 1, 5);
        $canvas->insertBlocks($this->body->legs->front, 2, 5);

        return $canvas;
    }

    public function portrait(){
        $canvas = imagecreatetruecolor(4*4, 4*4);
        $r = imagecolorallocate($canvas, 255, 0, 0);
        imagefill($canvas, 0, 0, self::getTransColor($canvas));
        imagecolortransparent($canvas, self::getTransColor($canvas));

        $canvas = new Image($canvas);
        $canvas->insertBlocks($this->body->head->front, 1, 0);
        $canvas->insertBlocks($this->body->arms->front, 0, 2);
        $canvas->insertBlocks($this->body->torso->front, 1, 2);
        $canvas->insertBlocks($this->body->arms->front, 3, 2);

        return $canvas;
    }

    private static function LoadPng($imgname){
        $im = imagecreatefrompng($imgname);
        if(!$im){
            $im = imagecreatefrompng("http://i.imgur.com/oEsKO.png");
        }

        
        if(!$im){
            $im = imagecreatetruecolor(150, 30);
            $bgc = imagecolorallocate($im, 255, 255, 255);
            $tc = imagecolorallocate($im, 0, 0, 0);

            imagefilledrectangle ($im, 0, 0, 150, 30, $bgc);
            imagestring ($im, 1, 5, 5, 'Error loading ' . $imgname, $tc);
        }

        return $im;
    }
}

class Body{
    public $hat;
    public $head;
    public $body;
    public $arms;
    public $legs;
}

class Part{
    public $skin;
    public $top;
    public $bottom;
    public $left;
    public $right;
    public $back;
    public $front;

    public function __construct($part = null, $partType = null){
        if($part && $partType){
            if($partType == "head"){
                $this->top = $part->getBlocks(0,2,2,2);
                $this->bottom = $part->getBlocks(0,4,2,2);
                $this->right = $part->getBlocks(2,0,2,2);
                $this->front = $part->getBlocks(2,2,2,2);
                $this->left = $part->getBlocks(2,4,2,2);
                $this->back = $part->getBlocks(2,6,2,2);
            }elseif($partType == "limb"){
                $this->top = $part->getBlocks(0,1,1,1);
                $this->bottom = $part->getBlocks(0,2,1,1);
                $this->right = $part->getBlocks(1,0,1,3);
                $this->front = $part->getBlocks(1,1,1,3);
                $this->left = $part->getBlocks(1,2,1,3);
                $this->back = $part->getBlocks(1,3,1,3);
            }elseif($partType = "torso"){
                $this->top = $part->getBlocks(0,1,2,1);
                $this->bottom = $part->getBlocks(0,3,2,1);
                $this->right = $part->getBlocks(1,0,1,3);
                $this->front = $part->getBlocks(1,1,2,3);
                $this->left = $part->getBlocks(1,3,1,3);
                $this->back = $part->getBlocks(1,4,2,3);
            }


            $this->skin = $part;
        }
    }
}

class Image{
    private $image;

    public function __construct($im){
        $this->image = $im;
    }
    
    public function getBlocks($sx, $sy, $w, $h){

        $sx *= 4;
        $sy *= 4;
        $w *= 4;
        $h *= 4;

        $canvas = imagecreatetruecolor($w, $h);
        imagefill($this->image, 0, 0, MinecraftCharacter::getTransColor($canvas));
        imagecolortransparent($canvas, MinecraftCharacter::getTransColor($canvas));

        imagecopy($canvas, $this->image, 0, 0, $sx, $sy, $w, $h);
        return new Image($canvas);
    }

    public function insertBlocks($src, $dx, $dy){
        $dx *= 4;
        $dy *= 4;
        
        imagecopy($this->image, $src->get(), $dx, $dy, 0, 0, imagesx($src->get()), imagesy($src->get()));

        return $this;
    }

    public function get($s = 1){

        if($s === 1){
            return $this->image;
        }

        $w = imagesx($this->image);
        $h = imagesy($this->image);

        $new_w = $w * $s;
        $new_h = $h * $s;

        $out = imagecreatetruecolor($new_w, $new_h);
        imagefill($out, 0, 0, MinecraftCharacter::getTransColor($out));
        imagecolortransparent($out, MinecraftCharacter::getTransColor($out));

        imagecopyresized($out, $this->image, 0, 0, 0, 0, $new_w, $new_h, $w, $h);

        return $out;
    }
}
?>