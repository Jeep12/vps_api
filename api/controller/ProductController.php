<?php
class ProductController
{

    public function __construct()
    {
        // Constructor vacío por ahora
    }

    public function getAllProducts()
    {
        // Verificar si los archivos existen
        $productModelPath =  'api/model/product.model.php';
        $apiViewPath =  'api/view/api-view.php';

        if (file_exists($productModelPath) && file_exists($apiViewPath)) {
            echo "Los archivos 'product.model.php' y 'api-view.php' se encuentran en las rutas especificadas.\n";
        } else {
            if (!file_exists($productModelPath)) {
                echo "Error: El archivo 'product.model.php' no se encuentra en la ruta especificada.\n";
            }
            if (!file_exists($apiViewPath)) {
                echo "Error: El archivo 'api-view.php' no se encuentra en la ruta especificada.\n";
            }
        }

        // Luego de verificar los archivos, incluirlos
        require_once $productModelPath;
        require_once $apiViewPath;

        // Verificar si las clases están disponibles
        if (class_exists('ProductsModel') && class_exists('APIView')) {
            echo "Las clases 'ProductsModel' y 'APIView' están disponibles.\n";
        } else {
            if (!class_exists('ProductsModel')) {
                echo "Error: La clase 'ProductsModel' no está disponible.\n";
            }
            if (!class_exists('APIView')) {
                echo "Error: La clase 'APIView' no está disponible.\n";
            }
        }
    }
}
