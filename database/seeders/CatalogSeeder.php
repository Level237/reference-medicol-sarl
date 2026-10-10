<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Catégories clés conformes à la maquette
        $categoriesData = [
            [
                'name' => 'Consultation',
                'slug' => 'consultation',
                'description' => 'Instruments et dispositifs pour examens et consultations médicales.',
                'sort_order' => 1,
                'is_published' => true,
            ],
            [
                'name' => 'Laboratoire',
                'slug' => 'laboratoire',
                'description' => 'Équipements d’analyse, microscopes et consommables de laboratoire.',
                'sort_order' => 2,
                'is_published' => true,
            ],
            [
                'name' => 'Mobilier médical',
                'slug' => 'mobilier-medical',
                'description' => 'Lits d’hospitalisation, tables d’examen et dessertes médicales.',
                'sort_order' => 3,
                'is_published' => true,
            ],
            [
                'name' => 'Bloc opératoire',
                'slug' => 'bloc-operatoire',
                'description' => 'Tables chirurgicales, scialytiques et matériel d’anesthésie-réanimation.',
                'sort_order' => 4,
                'is_published' => true,
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $catData) {
            $categories[$catData['slug']] = Category::query()->firstOrCreate(
                ['slug' => $catData['slug']],
                $catData
            );
        }

        // 2. Produits de démonstration fidèles à la maquette
        $productsData = [
            [
                'name' => 'Tensiomètre de poignet',
                'slug' => 'tensiometre-de-poignet',
                'category_id' => $categories['consultation']->id,
                'summary' => 'Tensiomètre digital compact avec détection d’arythmie et écran rétroéclairé.',
                'reference' => 'TEN-POI-01',
                'specifications' => ['Marque' => 'Omron', 'Type' => 'Digital', 'Garantie' => '2 ans'],
                'price' => null,
                'quantity' => 15,
                'sort_order' => 1,
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'name' => 'Microscope binoculaire',
                'slug' => 'microscope-binoculaire',
                'category_id' => $categories['laboratoire']->id,
                'summary' => 'Microscope optique haute résolution pour laboratoires cliniques et analyses de routine.',
                'reference' => 'MIC-BIN-02',
                'specifications' => ['Marque' => 'Olympus', 'Grossissement' => '1000x', 'Éclairage' => 'LED'],
                'price' => null,
                'quantity' => 5,
                'sort_order' => 2,
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'name' => 'Lit médicalisé',
                'slug' => 'lit-medicalise',
                'category_id' => $categories['mobilier-medical']->id,
                'summary' => 'Lit d’hospitalisation électrique multipositions avec barrières rabattables sécurisées.',
                'reference' => 'LIT-HOSP-03',
                'specifications' => ['Marque' => 'Hillrom', 'Fonctions' => 'Électrique', 'Roues' => 'Avec freins'],
                'price' => null,
                'quantity' => 8,
                'sort_order' => 3,
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'name' => 'Moniteur patient',
                'slug' => 'moniteur-patient',
                'category_id' => $categories['consultation']->id,
                'summary' => 'Moniteur multiparamétrique tactile pour soins intensifs et surveillance continue.',
                'reference' => 'MON-PAT-04',
                'specifications' => ['Marque' => 'Mindray', 'Écran' => '12.1 pouces', 'Paramètres' => 'ECG, SpO2, PNI, Temp'],
                'price' => null,
                'quantity' => 6,
                'sort_order' => 4,
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'name' => 'Stéthoscope',
                'slug' => 'stethoscope',
                'category_id' => $categories['consultation']->id,
                'summary' => 'Stéthoscope acoustique de précision en acier inoxydable avec double pavillon.',
                'reference' => 'STE-PRO-05',
                'specifications' => ['Marque' => 'Littmann', 'Pavillon' => 'Double', 'Garantie' => '5 ans'],
                'price' => null,
                'quantity' => 20,
                'sort_order' => 5,
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'name' => 'Table d’examen',
                'slug' => 'table-d-examen',
                'category_id' => $categories['mobilier-medical']->id,
                'summary' => 'Table de consultation médicale avec dossier réglable et revêtement antibactérien.',
                'reference' => 'TAB-EXA-06',
                'specifications' => ['Marque' => 'Promotal', 'Charge max' => '200 kg', 'Revêtement' => 'M1 lavable'],
                'price' => null,
                'quantity' => 10,
                'sort_order' => 6,
                'is_featured' => true,
                'is_published' => true,
            ],
        ];

        foreach ($productsData as $prodData) {
            Product::query()->firstOrCreate(
                ['slug' => $prodData['slug']],
                $prodData
            );
        }
    }
}
