<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Core Users (Admin, Agent, Buyer)
        $admin = User::firstOrCreate(
            ['email' => 'admin@realestate.test'],
            [
                'name' => 'Aditya Sharma (Admin)',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'phone' => '+91 98765 43210',
                'agency_name' => 'Gujarat Premier Realty',
            ]
        );

        $agent = User::firstOrCreate(
            ['email' => 'agent@realestate.test'],
            [
                'name' => 'Rajesh Patel (Senior Agent)',
                'password' => bcrypt('password'),
                'role' => 'agent',
                'phone' => '+91 98980 12345',
                'agency_name' => 'Heritage Properties Ahmedabad',
            ]
        );

        $buyer = User::firstOrCreate(
            ['email' => 'buyer@realestate.test'],
            [
                'name' => 'Pooja Mehta',
                'password' => bcrypt('password'),
                'role' => 'buyer',
                'phone' => '+91 97123 98765',
            ]
        );

        // 2. Create Categories
        $categories = [
            ['name' => 'Luxury Apartments', 'slug' => 'luxury-apartments', 'icon' => 'building-office', 'description' => 'High-rise 3/4 BHK premium flats with panoramic city views.'],
            ['name' => 'Villas & Bungalows', 'slug' => 'villas-bungalows', 'icon' => 'home', 'description' => 'Independent serene gated community villas.'],
            ['name' => 'Penthouses', 'slug' => 'penthouses', 'icon' => 'sparkles', 'description' => 'Top-floor sky villas with private terrace gardens.'],
            ['name' => 'Commercial Offices', 'slug' => 'commercial-offices', 'icon' => 'briefcase', 'description' => 'Grade-A corporate office suites on major business corridors.'],
            ['name' => 'Plots & Land', 'slug' => 'plots-land', 'icon' => 'map-pin', 'description' => 'NA plotted developments near upcoming metro hubs.'],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[$cat['slug']] = PropertyCategory::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 3. Create Features / Amenities
        $features = [
            'Swimming Pool',
            'Club House',
            '24/7 Security & CCTV',
            'Gymnasium',
            'Landscaped Garden',
            'EV Charging Station',
            'Power Backup',
            'Children Play Area',
            'Reserved Covered Parking',
            'High-Speed Elevators'
        ];

        $featureModels = [];
        foreach ($features as $fName) {
            $featureModels[] = Feature::firstOrCreate(
                ['slug' => Str::slug($fName)],
                ['name' => $fName, 'icon' => 'check-circle']
            );
        }

        // 4. Create Sample Ahmedabad Properties with Curated Photos
        $propertiesData = [
            [
                'category_slug' => 'luxury-apartments',
                'title' => '4 BHK Ultra Luxury Sky Residence in Bodakdev',
                'locality' => 'Bodakdev',
                'price' => 28500000,
                'area_sqft' => 3800,
                'bedrooms' => 4,
                'bathrooms' => 4,
                'balconies' => 3,
                'property_type' => 'sale',
                'is_featured' => true,
                'image_url' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Spectacular 4 BHK fully furnished luxury residence in prime Bodakdev. Features Italian marble flooring, VRV central AC, German modular kitchen, and scenic skyline views.',
            ],
            [
                'category_slug' => 'villas-bungalows',
                'title' => '5 BHK Mediterranean Style Garden Villa on SG Highway',
                'locality' => 'SG Highway',
                'price' => 65000000,
                'area_sqft' => 7200,
                'bedrooms' => 5,
                'bathrooms' => 6,
                'balconies' => 4,
                'property_type' => 'sale',
                'is_featured' => true,
                'image_url' => 'https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Sprawling 5 BHK gated villa with private pool, gazebo, and manicured lawns. Located in a high-profile gated society close to top international schools.',
            ],
            [
                'category_slug' => 'luxury-apartments',
                'title' => '3 BHK Modern Apartment in Prahlad Nagar',
                'locality' => 'Prahlad Nagar',
                'price' => 65000,
                'area_sqft' => 2100,
                'bedrooms' => 3,
                'bathrooms' => 3,
                'balconies' => 2,
                'property_type' => 'rent',
                'is_featured' => false,
                'image_url' => 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Elegantly furnished 3 BHK apartment ready to move in. High floor unit with ample cross ventilation, 2 covered car parks, and club access included.',
            ],
            [
                'category_slug' => 'commercial-offices',
                'title' => 'Corporate Grade-A Office Space in GIFT City',
                'locality' => 'GIFT City',
                'price' => 14500000,
                'area_sqft' => 1850,
                'bedrooms' => 0,
                'bathrooms' => 2,
                'balconies' => 0,
                'property_type' => 'sale',
                'is_featured' => true,
                'image_url' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Prime commercial IT/FinTech office unit in India’s leading International Financial Services Centre (GIFT City). Dual power feed, district cooling, and high rental yield.',
            ],
            [
                'category_slug' => 'penthouses',
                'title' => 'Duplex Penthouse with Private Jacuzzi Terrace',
                'locality' => 'Sindhu Bhavan Road',
                'price' => 42000000,
                'area_sqft' => 5400,
                'bedrooms' => 4,
                'bathrooms' => 5,
                'balconies' => 4,
                'property_type' => 'sale',
                'is_featured' => true,
                'image_url' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Exclusive duplex penthouse right off Sindhu Bhavan Road. Features a private wooden deck, Jacuzzi, double-height living room ceiling, and smart home automation.',
            ],
        ];

        foreach ($propertiesData as $prop) {
            $cat = $categoryModels[$prop['category_slug']];
            $property = Property::create([
                'agent_id' => $agent->id,
                'category_id' => $cat->id,
                'title' => $prop['title'],
                'slug' => Str::slug($prop['title']),
                'description' => $prop['description'],
                'price' => $prop['price'],
                'area_sqft' => $prop['area_sqft'],
                'bedrooms' => $prop['bedrooms'],
                'bathrooms' => $prop['bathrooms'],
                'balconies' => $prop['balconies'],
                'address' => $prop['locality'] . ', Ahmedabad, Gujarat',
                'locality' => $prop['locality'],
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'pincode' => '380015',
                'property_type' => $prop['property_type'],
                'status' => 'active',
                'is_featured' => $prop['is_featured'],
                'view_count' => rand(150, 2400),
            ]);

            // Attach features
            $property->features()->attach(
                collect($featureModels)->random(rand(4, 7))->pluck('id')
            );

            // Attach image via Spatie MediaLibrary from Remote URL
            try {
                $property->addMediaFromUrl($prop['image_url'])
                    ->toMediaCollection('images');
            } catch (\Throwable $e) {
                // Ignore if offline / curl timeout
            }
        }
    }
}
