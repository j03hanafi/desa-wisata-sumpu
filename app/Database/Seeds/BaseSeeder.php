<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BaseSeeder extends Seeder
{
    public function run()
    {
        // Rumah Gadang Seed
        $this->call('RecommendationSeeder');
        $this->call('RumahGadangSeeder');
        $this->call('FacilityRumahGadangSeeder');
        $this->call('DetailFacilityRumahGadangSeeder');
        $this->call('GalleryRumahGadangSeeder');
        $this->call('VideoRumahGadangSeeder');

        // Culinary Place Seed
        $this->call('CulinaryPlaceSeeder');
        $this->call('MenuSeeder');
        $this->call('DetailMenuSeeder');
        $this->call('FacilityCulinaryPlaceSeeder');
        $this->call('DetailFacilityCulinaryPlaceSeeder');
        $this->call('GalleryCulinaryPlaceSeeder');
        $this->call('VideoCulinaryPlaceSeeder');

        // Worship Place Seed
        $this->call('CategoryWorshipPlaceSeeder');
        $this->call('WorshipPlaceSeeder');
        $this->call('FacilityWorshipPlaceSeeder');
        $this->call('ConditionWorshipPlaceSeeder');
        $this->call('DetailFacilityWorshipPlaceSeeder');
        $this->call('GalleryWorshipPlaceSeeder');
        $this->call('VideoWorshipPlaceSeeder');

        // Souvenir Place Seed
        $this->call('SouvenirPlaceSeeder');
        $this->call('ProductSeeder');
        $this->call('DetailProductSeeder');
        $this->call('FacilitySouvenirPlaceSeeder');
        $this->call('DetailFacilitySouvenirPlaceSeeder');
        $this->call('GallerySouvenirPlaceSeeder');
        $this->call('VideoSouvenirPlaceSeeder');

        // Event Seed
        $this->call('CategoryEventSeeder');
        $this->call('EventSeeder');
        $this->call('GalleryEventSeeder');
        $this->call('VideoEventSeeder');

        // Other Seed
        $this->call('RoleSeeder');
        $this->call('AccountSeeder');
        $this->call('VisitHistorySeeder');
        $this->call('ReviewSeeder');
        $this->call('VillageSeeder');

    }
}
