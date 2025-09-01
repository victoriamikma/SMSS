<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class BooksTemplateExport implements FromArray, WithHeadings, WithTitle
{
    public function array(): array
    {
        $categories = Category::all();
        $categoryList = [];
        
        foreach ($categories as $category) {
            $categoryList[] = [$category->id, $category->name];
        }

        return [
            ['# BOOKS IMPORT TEMPLATE'],
            ['# Required columns: Title, Author, ISBN, Category ID, Total Copies, Available Copies'],
            ['# Optional columns: Publication Year, Publisher, Status, Description'],
            ['# Status options: available, maintenance, lost (default: available)'],
            [''],
            ['# AVAILABLE CATEGORIES:'],
            ...$categoryList,
            [''],
            ['# SAMPLE DATA:'],
        ];
    }

    public function headings(): array
    {
        return [
            'Title',
            'Author',
            'ISBN',
            'Category ID',
            'Total Copies',
            'Available Copies',
            'Publication Year',
            'Publisher',
            'Status',
            'Description'
        ];
    }

    public function title(): string
    {
        return 'Import Template';
    }
}