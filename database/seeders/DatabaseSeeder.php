<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuarios del sistema
        User::updateOrCreate(['email' => 'zaidmed587@gmail.com'], [
            'name' => 'zaiid',
            'password' => '$2y$12$PYsyrH419Abgo1d0S23AJuawikogVs79PTIaYL.R.0reYdKhyRhSq',
            'role' => 'admin',
            'username' => 'usuario_1',
            'apellido' => 'Medina Santillan',
            'telefono' => '7227705013',
            'edad' => 18,
            'localidad' => 'Santa Maria Nativitas centro numero 8',
        ]);

        User::updateOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Administrador',
            'password' => '$2y$12$r/8BOV0DbhIwGkkhNfRVSek.7SJ6NlKDG8up4xVTXilqsifIOG74O',
            'role' => 'admin',
            'username' => '',
            'apellido' => '',
            'telefono' => '555-987-6543',
            'edad' => 30,
            'localidad' => '',
        ]);

        User::updateOrCreate(['email' => 'juansanc09@gmail.com'], [
            'name' => 'Juan',
            'password' => '$2y$12$rq8E50PRIr2Wu5VcuiqPguspu1.1NXKZ6W57NepsqNisPQXzQu29S',
            'role' => 'cliente',
            'username' => '',
            'apellido' => '',
            'telefono' => '',
            'edad' => 18,
            'localidad' => '',
        ]);

        // Catálogo completo de Platillos y Bebidas MunchHub
        Product::updateOrCreate(['name' => 'Pizza Pepperoni Especial'], [
            'category' => 'Pizzas',
            'price' => 115,
            'stars' => 5,
            'prep_time' => '15-20 min',
            'short_description' => 'Masa artesanal a la piedra, salsa de tomate italiana, mozzarella fundido y abundante pepperoni crujiente.',
            'description' => 'Nuestra pizza estrella horneada a alta temperatura para lograr una base crujiente y bordes aireados. Cubierta con generosas rebanadas de pepperoni americano de primera calidad y queso mozzarella 100% de leche.',
            'image' => 'https://images.unsplash.com/photo-1628840042765-356cda07504e?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => true,
        ]);
        Product::updateOrCreate(['name' => 'Pizza Hawaiana Artesanal'], [
            'category' => 'Pizzas',
            'price' => 120,
            'stars' => 5,
            'prep_time' => '15-20 min',
            'short_description' => 'Deliciosa combinación de jamón premium seleccionado, piña dulce caramelizada al horno y queso mozzarella.',
            'description' => 'Un clásico irresistible. Horneada con piña fresca previamente asada a fuego lento para concentrar su dulzor natural y jamón de pierna horneado con especias.',
            'image' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => true,
        ]);
        Product::updateOrCreate(['name' => 'Pizza Cuatro Quesos Gourmet'], [
            'category' => 'Pizzas',
            'price' => 135,
            'stars' => 5,
            'prep_time' => '15-20 min',
            'short_description' => 'Mezcla cremosa de queso mozzarella, provolone ahumado, parmesano reggiano y un toque de queso gorgonzola.',
            'description' => 'Para los amantes del queso auténtico. Textura suave, dorada y con notas sutiles a hierbas mediterráneas.',
            'image' => 'https://images.unsplash.com/photo-1573821663912-569905455b1c?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => false,
        ]);
        Product::updateOrCreate(['name' => 'Pizza Carnes Frías Suprema'], [
            'category' => 'Pizzas',
            'price' => 140,
            'stars' => 5,
            'prep_time' => '20 min',
            'short_description' => 'Pepperoni crujiente, tocino ahumado, salchicha italiana y jamón de pierna sobre salsa marinara casera.',
            'description' => 'Cargada con cuatro tipos de carnes seleccionadas que desprenden un aroma irresistible en cada mordisco.',
            'image' => 'https://images.unsplash.com/photo-1534308983496-4fabb1a015ee?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => true,
        ]);
        Product::updateOrCreate(['name' => 'Pizza Mexicana con Chorizo y Jalapeño'], [
            'category' => 'Pizzas',
            'price' => 125,
            'stars' => 5,
            'prep_time' => '15-20 min',
            'short_description' => 'Chorizo toluqueño artesanal, rajas de chile jalapeño, cebolla morada y frijoles negros refritos.',
            'description' => 'Inspirada en el sabor del Valle de Toluca. Con chorizo rojo bien dorado y jalapeños frescos en escabeche.',
            'image' => 'https://images.unsplash.com/photo-1593560708920-61dd98c46a4e?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => false,
        ]);
        Product::updateOrCreate(['name' => 'Hamburguesa Clásica con Queso Cheddar'], [
            'category' => 'Hamburguesas',
            'price' => 95,
            'stars' => 5,
            'prep_time' => '12-15 min',
            'short_description' => '150g de carne de res molida al momento, queso cheddar fundido, jitomate, lechuga y aderezo especial.',
            'description' => 'Preparada en pan brioche artesanal ligeramente tostado con mantequilla. Carne jugosa sazonada solo con sal marina y pimienta negra recién molida.',
            'image' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => true,
        ]);
        Product::updateOrCreate(['name' => 'Hamburguesa Doble Carne con Papas y Tocino'], [
            'category' => 'Hamburguesas',
            'price' => 145,
            'stars' => 5,
            'prep_time' => '15-18 min',
            'short_description' => '300g de doble carne de res jugosa, doble queso americano, tiras de tocino ahumado extra crujiente y porción de papas.',
            'description' => 'La reina de las hamburguesas. Incluye una orden generosa de papas a la francesa recién fritas y aderezo chipotle de la casa.',
            'image' => 'https://images.unsplash.com/photo-1586190848861-99aa4a171e90?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => true,
        ]);
        Product::updateOrCreate(['name' => 'Hamburguesa BBQ Tocino Ahumado'], [
            'category' => 'Hamburguesas',
            'price' => 115,
            'stars' => 5,
            'prep_time' => '12-15 min',
            'short_description' => 'Carne 100% de res bañada en salsa BBQ casera al bourbon, aros de cebolla crujientes y queso suizo.',
            'description' => 'Un balance perfecto entre lo dulce, ahumado y salado con aros de cebolla recién empanizados dentro del pan brioche.',
            'image' => 'https://images.unsplash.com/photo-1550547660-d9450f859349?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => false,
        ]);
        Product::updateOrCreate(['name' => 'Hamburguesa de Pollo Crujiente Crispy'], [
            'category' => 'Hamburguesas',
            'price' => 90,
            'stars' => 5,
            'prep_time' => '12-15 min',
            'short_description' => 'Pechuga de pollo marinada en buttermilk, empanizado crujiente de especias, pepinillos y aderezo ranch.',
            'description' => 'Crujiente por fuera y sumamente jugosa por dentro. Servida en pan de ajonjolí recién horneado.',
            'image' => 'https://images.unsplash.com/photo-1625813506062-0aeb1d7a094b?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => false,
        ]);
        Product::updateOrCreate(['name' => 'Torta Cubana Gigante'], [
            'category' => 'Tortas',
            'price' => 95,
            'stars' => 5,
            'prep_time' => '12-15 min',
            'short_description' => 'Milanesa de res empanizada, pierna horneada, salchicha dorada, jamón, quesillo Oaxaca deshebrado y aguacate.',
            'description' => 'En pan telera dorado a la plancha con mantequilla, untada con frijoles refritos, mayonesa, rebanadas de jitomate, cebolla y chiles chipotle o jalapeño.',
            'image' => 'https://images.unsplash.com/photo-1525059696034-4967a8e1dca2?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => true,
        ]);
        Product::updateOrCreate(['name' => 'Torta de Milanesa con Quesillo'], [
            'category' => 'Tortas',
            'price' => 80,
            'stars' => 5,
            'prep_time' => '10-12 min',
            'short_description' => 'Milanesa de res suave y crujiente con abundante queso quesillo Oaxaca derretido a la plancha.',
            'description' => 'Un clásico de la cocina mexicana con aguacate fresco, frijoles refritos y chiles toreados.',
            'image' => 'https://images.unsplash.com/photo-1509722747041-616f39b57569?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => true,
        ]);
        Product::updateOrCreate(['name' => 'Torta de Pastor con Piña Asada'], [
            'category' => 'Tortas',
            'price' => 75,
            'stars' => 5,
            'prep_time' => '10 min',
            'short_description' => 'Carne al pastor marinada en achiote y chiles secos, con piña asada, cebolla y cilantro fresco.',
            'description' => 'Todo el sabor del trompo tradicional dentro de una telera crujiente con queso fundido opcional.',
            'image' => 'https://images.unsplash.com/photo-1619860860774-1e2e17343432?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => false,
        ]);
        Product::updateOrCreate(['name' => 'Tacos al Pastor con Piña'], [
            'category' => 'Tacos',
            'price' => 65,
            'stars' => 5,
            'prep_time' => '10 min',
            'short_description' => 'Cinco tacos en tortilla de maíz taquera con carne de cerdo marinada al pastor, piña dulce, cebolla y cilantro.',
            'description' => 'Carne dorada al momento en el comal, servida con doble copia de tortilla y acompañada de limones y salsas verde y roja caseras.',
            'image' => 'https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => true,
        ]);
        Product::updateOrCreate(['name' => 'Tacos de Suadero'], [
            'category' => 'Tacos',
            'price' => 70,
            'stars' => 5,
            'prep_time' => '10 min',
            'short_description' => 'Cinco tacos de suadero cocido a fuego lento en su propio jugo y dorado antes de picar.',
            'description' => 'Carne suave y con un sabor profundo inigualable. Se entregan con rábanos, cebollitas cambray asadas y limones.',
            'image' => 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => true,
        ]);
        Product::updateOrCreate(['name' => 'Tacos de Bistec con Queso Fundido'], [
            'category' => 'Tacos',
            'price' => 80,
            'stars' => 5,
            'prep_time' => '10-12 min',
            'short_description' => 'Bistec de res cortado en tiras tiernas a la plancha cubierto con queso manchego fundido.',
            'description' => 'Sabor casero insuperable. Se prepara al momento en la plancha con un toque de sazonador de la casa.',
            'image' => 'http://localhost/zaid-2/public/uploads/products/alimento_1794331578_6af353ba2a380.jpeg',
            'is_best_seller' => false,
        ]);
        Product::updateOrCreate(['name' => 'Tacos Campechanos Bistec y Longaniza'], [
            'category' => 'Tacos',
            'price' => 75,
            'stars' => 5,
            'prep_time' => '10 min',
            'short_description' => 'Mezcla perfecta de bistec de res picado y longaniza de Toluca bien dorada al comal.',
            'description' => 'El taco favorito de muchos por su intensidad de sabor y textura crocante de la longaniza.',
            'image' => 'https://images.unsplash.com/photo-1599974579688-8dbdd335c77f?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => false,
        ]);
        Product::updateOrCreate(['name' => 'Refresco Coca-Cola'], [
            'category' => 'Bebidas',
            'price' => 28,
            'stars' => 5,
            'prep_time' => 'Inmediato',
            'short_description' => 'Refresco de cola original en lata fría de 355 ml. Disponible fría, al tiempo o con vaso con hielos.',
            'description' => 'La bebida refrescante por excelencia para acompañar tus pizzas, hamburguesas y tacos.',
            'image' => 'https://happyfood-zaid.duckdns.org/uploads/products/alimento_1795063960_6afe80986b938.jpg',
            'is_best_seller' => true,
        ]);
        Product::updateOrCreate(['name' => 'Refresco Sprite'], [
            'category' => 'Bebidas',
            'price' => 28,
            'stars' => 5,
            'prep_time' => 'Inmediato',
            'short_description' => 'Refresco sabor lima-limón en lata fría de 355 ml. Burbujeante y refrescante.',
            'description' => 'Sabor cítrico limpio y burbujas intensas. Puedes pedirlo bien frío o con vaso y hielo.',
            'image' => 'https://images.unsplash.com/photo-1625772299848-391b6a87d7b3?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => false,
        ]);
        Product::updateOrCreate(['name' => 'Refresco Sidral Mundet'], [
            'category' => 'Bebidas',
            'price' => 28,
            'stars' => 5,
            'prep_time' => 'Inmediato',
            'short_description' => 'El auténtico refresco mexicano de manzana pasteurizada en lata de 355 ml.',
            'description' => 'Sabor tradicional a manzana dulce con efervescencia suave y agradable.',
            'image' => 'http://localhost/zaid-2/public/uploads/products/alimento_1794332972_6af3592c58822.webp',
            'is_best_seller' => false,
        ]);
        Product::updateOrCreate(['name' => 'Refresco Jarrito de Mandarina'], [
            'category' => 'Bebidas',
            'price' => 25,
            'stars' => 5,
            'prep_time' => 'Inmediato',
            'short_description' => 'Tradicional refresco Jarritos con auténtico sabor a mandarina mexicana.',
            'description' => 'Tradicional refresco Jarritos con auténtico sabor a mandarina mexicana. Elaborado con azúcar de caña. Disponible en presentación de 600 ml y 2 Litros.',
            'image' => 'http://localhost/zaid-2/public/uploads/products/alimento_1794168656_6af0d750cb16e.jpeg',
            'is_best_seller' => false,
        ]);
        Product::updateOrCreate(['name' => 'Agua Fresca de Horchata Artesanal'], [
            'category' => 'Bebidas',
            'price' => 35,
            'stars' => 5,
            'prep_time' => '3 min',
            'short_description' => 'Elaborada diariamente con arroz seleccionado, leche condensada, canela molida y vainilla natural.',
            'description' => 'Cremosa, dulce en su punto exacto y servida con hielo frappé para una frescura insuperable.',
            'image' => 'http://localhost/zaid-2/public/uploads/products/alimento_1794332876_6af358cc53ed2.jpg',
            'is_best_seller' => true,
        ]);
        Product::updateOrCreate(['name' => 'Agua Fresca de Jamaica Cítrica'], [
            'category' => 'Bebidas',
            'price' => 35,
            'stars' => 5,
            'prep_time' => '3 min',
            'short_description' => 'Flor de jamaica natural hervida con infusión de cáscara de naranja y endulzada con azúcar de caña.',
            'description' => 'Color rubí brillante y sabor balanceado entre lo ácido y lo dulce. Muy hidratante y fresca.',
            'image' => 'http://localhost/zaid-2/public/uploads/products/alimento_1794332843_6af358abf33c9.jpeg',
            'is_best_seller' => true,
        ]);
        Product::updateOrCreate(['name' => 'Agua Fresca de Limón con Chía'], [
            'category' => 'Bebidas',
            'price' => 35,
            'stars' => 5,
            'prep_time' => '3 min',
            'short_description' => 'Limones verdes recién exprimidos con semillas de chía activadas y hielo abundante.',
            'description' => 'La opción más ligera y refrescante, ideal para limpiar el paladar entre platillos.',
            'image' => 'http://localhost/zaid-2/public/uploads/products/alimento_1794332922_6af358fae5556.jpg',
            'is_best_seller' => false,
        ]);
        Product::updateOrCreate(['name' => 'Papas a la Francesa Crujientes'], [
            'category' => 'Papas',
            'price' => 55,
            'stars' => 5,
            'prep_time' => '8-10 min',
            'short_description' => 'Papas naturales en bastones dorados y crujientes por fuera, suaves por dentro, con sal marina fina.',
            'description' => 'Fritas al punto exacto con aceite limpio de girasol. Se acompañan con salsa catsup y queso cheddar caliente.',
            'image' => 'http://localhost/zaid-2/public/uploads/products/alimento_1794331522_6af3538227478.jpg',
            'is_best_seller' => true,
        ]);
        Product::updateOrCreate(['name' => 'Papas Gajo Rústicas con Finas Hierbas'], [
            'category' => 'Papas',
            'price' => 65,
            'stars' => 5,
            'prep_time' => '10-12 min',
            'short_description' => 'Gajos de papa con cáscara sazonados con páprika dulce, ajo en polvo, orégano y romero.',
            'description' => 'Horneadas y fritas para lograr una corteza súper crocante. Se sirven con dip de aderezo ranch o queso amarillo.',
            'image' => 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => true,
        ]);
        Product::updateOrCreate(['name' => 'Pan Dulce Surtido Artesanal'], [
            'category' => 'Panadería',
            'price' => 35,
            'stars' => 5,
            'prep_time' => 'Inmediato',
            'short_description' => 'Tres piezas a elegir: concha de chocolate o vainilla, cuerno de mantequilla y dona azucarada.',
            'description' => 'Horneado cada mañana con harina de trigo seleccionada y mantequilla pura de rancho.',
            'image' => 'http://localhost/zaid-2/public/uploads/products/alimento_1794331454_6af3533edc75f.jpeg',
            'is_best_seller' => false,
        ]);
        Product::updateOrCreate(['name' => 'Pan Francés con Miel y Frutos Rojos'], [
            'category' => 'Panadería',
            'price' => 60,
            'stars' => 5,
            'prep_time' => '10 min',
            'short_description' => 'Rebanadas de pan brioche bañadas en huevo, leche y canela, doradas con mantequilla y miel de maple.',
            'description' => 'Acompañado con fresas y moras frescas espolvoreado con azúcar glas.',
            'image' => 'https://images.unsplash.com/photo-1484723091739-30a097e8f929?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => false,
        ]);
        Product::updateOrCreate(['name' => 'Flan Napolitano de Vainilla Casero'], [
            'category' => 'Postres',
            'price' => 45,
            'stars' => 5,
            'prep_time' => 'Inmediato',
            'short_description' => 'Flan tradicional cremoso hecho con queso crema, leche condensada y abundante caramelo dorado.',
            'description' => 'Receta clásica de la abuela. Textura suave, densa y sin grumos, con el toque perfecto de vainilla de Papantla.',
            'image' => 'https://images.unsplash.com/photo-1587314168485-3236d6710814?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => true,
        ]);
        Product::updateOrCreate(['name' => 'Flan de Café Moka Especial'], [
            'category' => 'Postres',
            'price' => 48,
            'stars' => 5,
            'prep_time' => 'Inmediato',
            'short_description' => 'Exquisita combinación de flan napolitano infusionado con café espresso tostado y notas de cacao.',
            'description' => 'Para quienes disfrutan del aroma y sabor profundo del café en un postre suave y elegante.',
            'image' => 'https://images.unsplash.com/photo-1579954115545-a95591f28bfc?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => false,
        ]);
        Product::updateOrCreate(['name' => 'Gelatina Mosaico Tricolor'], [
            'category' => 'Postres',
            'price' => 38,
            'stars' => 5,
            'prep_time' => 'Inmediato',
            'short_description' => 'Cubos de gelatina de uva, fresa y limón envueltos en una cremosa base de leche condensada y vainilla.',
            'description' => 'Postre fresco, ligero y colorido, perfecto para los más pequeños o para finalizar una comida completa.',
            'image' => 'http://localhost/zaid-2/public/uploads/products/alimento_1794332757_6af358550eed4.jpeg',
            'is_best_seller' => false,
        ]);
        Product::updateOrCreate(['name' => 'Pay de Limón Frío Artesanal'], [
            'category' => 'Postres',
            'price' => 50,
            'stars' => 5,
            'prep_time' => 'Inmediato',
            'short_description' => 'Base crujiente de galleta María con crema batida de limón verde y ralladura fresca en la superficie.',
            'description' => 'El pay frío consentido de todos. Textura aterciopelada y acidez equilibrada que no empalaga.',
            'image' => 'https://images.unsplash.com/photo-1519869325930-281384150729?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => true,
        ]);
        Product::updateOrCreate(['name' => 'Café Americano Gardello Clásico'], [
            'category' => 'Cafetería',
            'price' => 32,
            'stars' => 5,
            'prep_time' => '3 min',
            'short_description' => 'Café de grano selecto tostado oscuro con notas a nuez y madera. Disponible en tamaño Chico o Grande.',
            'description' => 'Café 100% arábica de altura cosechado en fincas mexicanas. Se sirve recién infusionado, caliente y aromático.',
            'image' => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => false,
        ]);
        Product::updateOrCreate(['name' => 'Café Gardello Moka'], [
            'category' => 'Cafetería',
            'price' => 42,
            'stars' => 5,
            'prep_time' => '4 min',
            'short_description' => 'Espresso de café Gardello combinado con chocolate semiamargo derretido y leche espumada cremosa.',
            'description' => 'La fusión predilecta entre café caliente y cocoa fina con un toque de canela. Disponible en tamaño Chico o Grande.',
            'image' => 'https://images.unsplash.com/photo-1517701550927-30cf4ba1dba5?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => true,
        ]);
        Product::updateOrCreate(['name' => 'Café Gardello Vainilla'], [
            'category' => 'Cafetería',
            'price' => 45,
            'stars' => 5,
            'prep_time' => '4 min',
            'short_description' => 'Café espresso con jarabe de vainilla francesa, chocolate blanco y crema batida encima.',
            'description' => 'Un café suave y dulce para consentirte en cualquier momento del día. Disponible en tamaño Chico o Grande.',
            'image' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=800&auto=format&fit=crop&q=80',
            'is_best_seller' => false,
        ]);
        Product::updateOrCreate(['name' => 'Refresco Jarrito de Tamarindo'], [
            'category' => 'Bebidas',
            'price' => 25,
            'stars' => 5,
            'prep_time' => '15-20 min',
            'short_description' => 'El clásico Jarrito sabor tamarindo con balance dulce y acidito.',
            'description' => 'El clásico Jarrito sabor tamarindo, equilibrado entre lo dulce y lo acidito. Disponible en 600 ml y 2 Litros.',
            'image' => 'https://images.unsplash.com/photo-1543253687-c931c8e01820?w=500&auto=format&fit=crop&q=60',
            'is_best_seller' => false,
        ]);
        Product::updateOrCreate(['name' => 'Refresco Jarrito de Toronja'], [
            'category' => 'Bebidas',
            'price' => 25,
            'stars' => 5,
            'prep_time' => '15-20 min',
            'short_description' => 'Jarrito sabor toronja cítrica refrescante.',
            'description' => 'Jarrito sabor toronja cítrica refrescante. Ideal para acompañar tacos o tortas. Disponible en 600 ml y 2 Litros.',
            'image' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=500&auto=format&fit=crop&q=60',
            'is_best_seller' => false,
        ]);
        Product::updateOrCreate(['name' => 'Refresco Jarrito de Piña'], [
            'category' => 'Bebidas',
            'price' => 25,
            'stars' => 5,
            'prep_time' => '15-20 min',
            'short_description' => 'Delicioso refresco Jarritos sabor piña caribeña.',
            'description' => 'Delicioso refresco Jarritos sabor piña caribeña. Disponible en 600 ml y 2 Litros.',
            'image' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?w=500&auto=format&fit=crop&q=60',
            'is_best_seller' => false,
        ]);
        Product::updateOrCreate(['name' => 'Refresco Jarrito de Frutas'], [
            'category' => 'Bebidas',
            'price' => 25,
            'stars' => 5,
            'prep_time' => '15-20 min',
            'short_description' => 'Jarrito Ponche de Frutas tradicional mexicano.',
            'description' => 'Jarrito Ponche de Frutas tradicional con sabor a frutas rojas y cítricos. Disponible en 600 ml y 2 Litros.',
            'image' => 'https://images.unsplash.com/photo-1534353473418-4cfa6c56fd38?w=500&auto=format&fit=crop&q=60',
            'is_best_seller' => false,
        ]);
        Product::updateOrCreate(['name' => 'Refresco Jarrito de Lima'], [
            'category' => 'Bebidas',
            'price' => 25,
            'stars' => 5,
            'prep_time' => '15-20 min',
            'short_description' => 'Jarrito sabor lima fresca, el balance perfecto de acidez.',
            'description' => 'Jarrito sabor lima fresca, el balance perfecto de acidez y frescura natural. Disponible en 600 ml y 2 Litros.',
            'image' => 'https://images.unsplash.com/photo-1527661591475-527312dd65f5?w=500&auto=format&fit=crop&q=60',
            'is_best_seller' => false,
        ]);
    }
}
