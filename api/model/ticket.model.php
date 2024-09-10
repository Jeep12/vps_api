<?php
echo "pase porca";
require_once("model.php");

class TicketModel extends Model {

    public function getAllTickets() {
        $sql = "
        SELECT 
            u.nombre AS usuario_nombre,
            u.apellido AS usuario_apellido,  -- Asegúrate de que este campo esté en tu tabla
            u.direccion AS direccion,  -- Asegúrate de que este campo esté en tu tabla
            f.id AS factura_id,
            f.fecha,
            df.id AS detalle_id,
            df.producto_id,
            df.servicio_id,
            p.nombre AS producto_nombre,
            p.marca AS producto_marca,
            p.descripcion AS producto_descripcion,
            s.nombre AS servicio_nombre,
            s.descripcion AS servicio_descripcion,
            df.cantidad,
            df.precio
        FROM 
            facturas f
        JOIN 
            usuarios u ON f.usuario_id = u.id
        LEFT JOIN 
            detalle_factura df ON f.id = df.factura_id
        LEFT JOIN 
            productos p ON df.producto_id = p.id
        LEFT JOIN 
            servicios s ON df.servicio_id = s.id
        ORDER BY 
            f.id, df.id;
        ";

        // Ejecutar la consulta y obtener los resultados
        $query = $this->pdo->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }
}
?>
