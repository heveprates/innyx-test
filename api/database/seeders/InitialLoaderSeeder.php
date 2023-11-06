<?php

namespace Database\Seeders;

use App\Contracts\Services\CategoryServiceInterface;
use App\Contracts\Services\ProductServiceInterface;
use App\DataTransferObjects\Category\CategoryCreateDTO;
use App\DataTransferObjects\Product\ProductCreateDTO;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;


class InitialLoaderSeeder extends Seeder
{

    private ProductServiceInterface $productService;
    private CategoryServiceInterface $categoryService;

    public function run(): void
    {
        $this->productService = app(ProductServiceInterface::class);
        $this->categoryService = app(CategoryServiceInterface::class);
        $entries = [
            [
                'Alimentos',
                [
                    [
                        'name' => 'Arroz',
                        'description' => 'Arroz tipo 1',
                        'price' => 10.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl(
                            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRkN5XbuyEzyur90sNekH3Gf6wX1OfSDIAm0g&usqp=CAU'
                        ),
                    ],
                    [
                        'name' => 'Feijão',
                        'description' => 'Feijão carioca',
                        'price' => 8.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTkJ-M-ToJjUcWDI2N1ZKik4aak-M7dByyKUg&usqp=CAU'),
                    ],
                    [
                        'name' => 'Macarrão',
                        'description' => 'Macarrão espaguete',
                        'price' => 5.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTboZYmYed9TPt0NpBZXUZVfYOl712oZjO_1w&usqp=CAU'),
                    ],
                    [
                        'name' => 'Óleo',
                        'description' => 'Óleo de soja',
                        'price' => 5.00,
                        'dateValidity' => new \DateTime('2033-12-31'),

                        'image' => $this->uploadFromUrl('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTD43fQN58gwR4TFxHQjIAknSPwVjT3Jj9Tow&usqp=CAU'),
                    ]
                ]
            ],
            [
                'Bebidas',
                [
                    [
                        'name' => 'Coca-Cola',
                        'description' => 'Refrigerante de cola',
                        'price' => 5.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://images.tcdn.com.br/img/img_prod/881726/180_coca_cola_zero_lata_350_ml_307_1_20201124155821.jpg'),
                    ],
                    [
                        'name' => 'Guaraná',
                        'description' => 'Refrigerante de guaraná',
                        'price' => 5.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://cdn.shopify.com/s/files/1/0266/4316/9342/products/guarana-original-antarctica-lata-330_1200x1200.png?v=1603716439'),
                    ],
                    [
                        'name' => 'Suco de laranja',
                        'description' => 'Suco de laranja natural',
                        'price' => 5.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://th.bing.com/th/id/OIP.A4mDq7wYNF4Hoxsny72GIgHaHa?pid=ImgDet&rs=1'),
                    ],
                    [
                        'name' => 'Suco de uva',
                        'description' => 'Suco de uva natural',
                        'price' => 5.00,
                        'dateValidity' => new \DateTime('2033-12-31'),

                        'image' => $this->uploadFromUrl('https://img.onofre.com.br/catalog/product/s/u/suco-de-uva-natural-one-300ml-7899916904716.jpg?width=1800&height=1800&quality=85&type=resize'),
                    ]
                ]
            ],
            [
                'Higiene',
                [
                    [
                        'name' => 'Sabonete',
                        'description' => 'Sabonete líquido',
                        'price' => 5.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://th.bing.com/th/id/OIP.-Emwyd9b5PZ8xOs0kGnPuwHaHa?pid=ImgDet&rs=1'),
                    ],
                    [
                        'name' => 'Shampoo',
                        'description' => 'Shampoo para cabelos',
                        'price' => 5.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://th.bing.com/th/id/OIP.ATbKDYkkHDg76U0nek2TSAHaHa?pid=ImgDet&rs=1'),
                    ],
                    [
                        'name' => 'Condicionador',
                        'description' => 'Condicionador para cabelos',
                        'price' => 5.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://th.bing.com/th/id/OIP.Bli5rjZO40yx8QMBxdxLbwHaHa?pid=ImgDet&rs=1'),
                    ],
                    [
                        'name' => 'Creme dental',
                        'description' => 'Creme dental para escovação',
                        'price' => 5.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://th.bing.com/th/id/R.1b11de1ccd36a602093b6759d9c760ce?rik=fNl%2bSwIBuwl66A&pid=ImgRaw&r=0'),
                    ]
                ]

            ],
            [
                'Limpeza',
                [
                    [
                        'name' => 'Sabão em pó',
                        'description' => 'Sabão em pó para roupas',
                        'price' => 5.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://th.bing.com/th/id/OIP.G-kLqb-uzk8TuisN2Xld3wHaHa?pid=ImgDet&rs=1'),

                    ],
                    [
                        'name' => 'Sabão em barra',
                        'description' => 'Sabão em barra para roupas',
                        'price' => 5.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://cdn.iset.io/assets/55218/produtos/218/sabaoglicerinado.jpg'),

                    ],
                    [
                        'name' => 'Desinfetante',
                        'description' => 'Desinfetante para limpeza',
                        'price' => 5.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://www.tempusquimica.com.br/wp-content/uploads/2020/10/900x900-Copia-12-1.png'),

                    ],
                    [
                        'name' => 'Água sanitária',
                        'description' => 'Água sanitária para limpeza',
                        'price' => 5.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://comper.vteximg.com.br/arquivos/ids/178690-1000-1000/agua-Sanitaria-Qboa-2L.jpg?v=637364619897370000'),
                    ]
                ]
            ],
            [
                'Eletrônicos',
                [
                    [
                        'name' => 'Smartphone',
                        'description' => 'Smartphone Samsung Galaxy S21 Ultra 5G 256GB 12GB RAM Tela 6,8" Câmera Quádrupla Traseira 108MP + Selfie 40MP - Preto',
                        'price' => 9999.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://th.bing.com/th/id/R.4b849d6c350f62106bad3bb1bc6ce176?rik=zIZTzOrrQkfqfw&riu=http%3a%2f%2fwww.asus.com%2fmedia%2fglobal%2fproducts%2f9EadKfrQhPM5nsL5%2fvv5HmtMxcvzr5ham_500.jpg&ehk=eb0ugl0KQ6f1CdHfMSYPIrFd59UqbYT2J93o5fX4GlY%3d&risl=&pid=ImgRaw&r=0'),

                    ],
                    [
                        'name' => 'Notebook',
                        'description' => 'Notebook Samsung Book E30 Intel Core i3 4GB 1TB Tela Full HD 15,6” Windows 10 - Preto',
                        'price' => 2999.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://th.bing.com/th/id/R.e446511c64742e02f6216710e75d5391?rik=LqsFLY8fy4TwiQ&pid=ImgRaw&r=0'),

                    ],
                    [
                        'name' => 'Smart TV',
                        'description' => 'Smart TV LED 50" Samsung 50AU7700 Crystal UHD 4K com Controle Remoto Único, Visual Livre de Cabos, Bluetooth, HDR Premium, HDMI e USB',
                        'price' => 2999.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://th.bing.com/th/id/R.9a3ace0e33ea99278a5f516553f43f85?rik=%2bJKOAe8ZdODyxQ&riu=http%3a%2f%2fwww.lgnewsroom.com%2fwp-content%2fuploads%2f2012%2f12%2fLG_SMART_TV-02.jpg&ehk=%2f4iSDTJXA5fjI3JMP589gyKYY3mAZM%2bNe2vzWjUovPw%3d&risl=&pid=ImgRaw&r=0'),

                    ],
                    [
                        'name' => 'PS5',
                        'description' => 'Console PlayStation 5 PS5 com Controle DualSense',
                        'price' => 2999.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://th.bing.com/th/id/OIP.MuQ0cHKkxe7IFXuX9kaIxwHaD-?pid=ImgDet&rs=1'),
                    ]
                ]
            ],
            [
                'Eletrodomésticos',
                [
                    [
                        'name' => 'Geladeira',
                        'description' => 'Geladeira/Refrigerador Electrolux Frost Free Bottom Freezer DB84 579L Inox 220V',
                        'price' => 9999.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://th.bing.com/th/id/OIP.QVjKIfKAkbOChuBC3Zft-wHaHi?pid=ImgDet&rs=1'),

                    ],
                    [
                        'name' => 'Fogão',
                        'description' => 'Fogão 5 Bocas Electrolux 76SQB Tripla Chama e Queimador Rápido Bivolt Inox',
                        'price' => 2999.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://th.bing.com/th/id/R.8fb666ab7c160750c34da10cad3bb573?rik=nG54bG99TpAsmA&pid=ImgRaw&r=0'),

                    ],
                    [
                        'name' => 'Microondas',
                        'description' => 'Micro-ondas Electrolux 20L MTD30 Branco 220V',
                        'price' => 2999.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://th.bing.com/th/id/R.c395827ac2cb27a698db6afcf6b2a00d?rik=qNafLps%2facZNQQ&pid=ImgRaw&r=0'),

                    ],
                    [
                        'name' => 'Lava-louças',
                        'description' => 'Lava-Louças Electrolux 14 Serviços 10 Programas de Lavagem Inox 220V',
                        'price' => 2999.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://th.bing.com/th/id/OIP.hTvCkV5Md27TPCV5LjYXkwHaHa?pid=ImgDet&rs=1'),
                    ]
                ]
            ],
            [
                'Móveis',
                [
                    [
                        'name' => 'Sofá',
                        'description' => 'Sofá 3 Lugares Retrátil e Reclinável',
                        'price' => 9999.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://th.bing.com/th/id/R.1fa6be7e24ad96bf26ad35f0d6d14a83?rik=R2fXT%2f%2fwrC7Bmw&riu=http%3a%2f%2fwww.stylussofas.com%2fproduct_images%2fsofa_ellyn-lg.jpg&ehk=5xQMnaZZrnZre8yYtA8fC6fa2J4CI1p61yikzN4I2wg%3d&risl=&pid=ImgRaw&r=0'),
                    ],
                    [
                        'name' => 'Cama',
                        'description' => 'Cama Box Casal + Colchão de Molas Ensacadas',
                        'price' => 2999.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://th.bing.com/th/id/OIP.P1kHZF3kSrIXXT30achI3gHaEK?pid=ImgDet&rs=1'),
                    ],
                    [
                        'name' => 'Guarda-roupa',
                        'description' => 'Guarda-Roupa Casal 6 Portas 3 Gavetas',
                        'price' => 2999.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://a-static.mlcdn.com.br/1500x1500/guarda-roupa-casal-6-portas-6-gavetas-castellaro-moveis-lopas-branco/madeiramadeira-openapi/239973/fb83a403ef8b4f9da6a2e91cd14aa607.jpg'),
                    ],
                    [
                        'name' => 'Mesa',
                        'description' => 'Mesa de Jantar 6 Lugares',
                        'price' => 2999.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://th.bing.com/th/id/OIP.fWfUfEgwqIwHTpwZzNu_WQHaE7?pid=ImgDet&rs=1'),
                    ]
                ],
            ],
            [
                'Roupas',
                [
                    [
                        'name' => 'Camiseta',
                        'description' => 'Camiseta Masculina Manga Curta',
                        'price' => 99.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://cdn.awsli.com.br/1000x1000/1236/1236987/produto/63088094/0ca7bb8676.jpg'),
                    ],
                    [
                        'name' => 'Calça',
                        'description' => 'Calça Jeans Masculina',
                        'price' => 299.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://2.bp.blogspot.com/-Ptk9E8Worz0/T3y_rn463XI/AAAAAAAAJ3w/xOMG1PQ-yrk/s1600/salsaboyfriend+fundo+branco.jpg'),
                    ],
                    [
                        'name' => 'Tênis',
                        'description' => 'Tênis Masculino',
                        'price' => 199.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://th.bing.com/th/id/OIP.gt6UtygIdiCGQI2lLXTfgQHaHa?pid=ImgDet&rs=1'),
                    ],
                    [
                        'name' => 'Vestido',
                        'description' => 'Vestido Feminino',
                        'price' => 299.00,
                        'dateValidity' => new \DateTime('2033-12-31'),
                        'image' => $this->uploadFromUrl('https://ae01.alicdn.com/kf/HTB1EtQnSXXXXXbcXpXXq6xXFXXXu/7-15Y-Teenager-Vestido-Lace-Flower-Girl-Dresses-Princess-Pageant-Wedding-Bridesmaid-Birthday-Party-Dress-Ball.jpg'),
                    ]
                ]
            ],
        ];

        $this->createUser();
        foreach ($entries as $entry) {
            $this->createEntry($entry[0], $entry[1]);
        }
    }

    private function createUser(): void
    {
        User::create([
            'name' => 'Test User',
            'email' => 'innyx@user.test',
            'password' => Hash::make('1234'),
        ]);
    }

    private function createEntry(string $categoryName, array $products): void
    {
        $category = $this->categoryService->create(new CategoryCreateDTO($categoryName));
        foreach ($products as $product) {
            $this->productService->create(
                new ProductCreateDTO(
                    $product['name'],
                    $product['description'],
                    $product['price'],
                    $product['dateValidity'],
                    $product['image'],
                    $category->id,
                )
            );
        }
    }

    private function uploadFromUrl(string $url): UploadedFile
    {
        $file = tempnam('/tmp/', 'seed_');
        $contents = file_get_contents($url);
        return UploadedFile::fake()->createWithContent($file, $contents);
    }
}
