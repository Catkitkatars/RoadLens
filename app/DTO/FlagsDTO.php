<?php 
namespace App\DTO;



class FlagsDTO {

    public string $verified;
    public string $rear;
    public string $markup;
    public string $crosswalk;
    public string $roadside;
    public string $busLine;
    public string $stopMonitoring;
    public string $cargoControl;
    public string $additional;

    public function __construct(
          $verified,
          $rear,
          $markup,
          $crosswalk,
          $roadside,
          $busLine,
          $stopMonitoring,
          $cargoControl,
          $additional,
    ) {}
}