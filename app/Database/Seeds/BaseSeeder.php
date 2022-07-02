<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BaseSeeder extends Seeder
{
    public function run()
    {
        // Account Seed
        $this->call('RoleSeeder');
        $this->call('AccountSeeder');
        $this->call('VillageSeeder');

        // Rumah Gadang Seed
        $this->call('RecommendationSeeder');
        $this->call('RumahGadangSeeder');
        $this->call('FacilityRumahGadangSeeder');
        $this->call('DetailFacilityRumahGadangSeeder');
        $this->call('GalleryRumahGadangSeeder');

        // Culinary Place Seed
        $this->call('CulinaryPlaceSeeder');
        $this->call('GalleryCulinaryPlaceSeeder');

        // Worship Place Seed
        $this->call('WorshipPlaceSeeder');
        $this->call('GalleryWorshipPlaceSeeder');

        // Souvenir Place Seed
        $this->call('SouvenirPlaceSeeder');
        $this->call('GallerySouvenirPlaceSeeder');

        // Event Seed
        $this->call('CategoryEventSeeder');
        $this->call('EventSeeder');
        $this->call('GalleryEventSeeder');

        // Other Seed
        $this->call('VisitHistorySeeder');
        $this->call('ReviewSeeder');
    }
}
