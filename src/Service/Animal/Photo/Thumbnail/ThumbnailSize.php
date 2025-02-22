<?php

namespace App\Service\Animal\Photo\Thumbnail;

/**
 * Adding a new thumbnail size requires adding a new value to \App\Entity\AnimalPhoto
 */
enum ThumbnailSize : int
{
    case Big = 1200;
    case Medium = 800;
    case Small = 400;
}
