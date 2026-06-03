<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [

            [
                'name' => 'الأدب',
                'description' => 'الروايات والقصص والنصوص الأدبية والشعر'
            ],

            [
                'name' => 'التاريخ',
                'description' => 'كتب التاريخ والحضارات والأحداث التاريخية'
            ],

            [
                'name' => 'الدين',
                'description' => 'العلوم الشرعية والفقه والسيرة'
            ],

            [
                'name' => 'الفلسفة',
                'description' => 'الفكر والفلسفة والمنطق'
            ],

            [
                'name' => 'علوم الحاسوب',
                'description' => 'البرمجة وقواعد البيانات والشبكات'
            ],

            [
                'name' => 'الإدارة والأعمال',
                'description' => 'الإدارة والتسويق والاقتصاد'
            ],

            [
                'name' => 'العلوم',
                'description' => 'الفيزياء والكيمياء والأحياء والرياضيات'
            ],

        ];

        Category::insert($categories);
    }
}
