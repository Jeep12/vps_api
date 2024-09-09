<?php
require_once("api/view/api-view.php");
require_once("api/model/ticket.model.php");

class TicketController {

    private $modelTicket;
    private $view;

    public function __construct() {
        $this->modelTicket = new TicketModel();
        $this->view = new APIView();
    }

    public function getAllTickets() {
        $tickets = $this->modelTicket->getAllTickets();
        if ($tickets) {
            $formattedTickets = $this->formatTickets($tickets);
            $this->view->response($formattedTickets, 200);
        } else {
            $this->view->response("No se encontraron tickets", 404);
        }
    }

    private function formatTickets($tickets) {
        $formatted = [];
        
        foreach ($tickets as $ticket) {
            $factura_id = $ticket['factura_id'];
            
            if (!isset($formatted[$factura_id])) {
                $formatted[$factura_id] = [
                    'usuario_nombre' => $ticket['usuario_nombre'],
                    'usuario_apellido' => $ticket['usuario_apellido'],
                    'direccion' => $ticket['direccion'],
                    'factura_id' => $ticket['factura_id'],
                    'fecha' => $ticket['fecha'],
                    'total' => 0, // Inicialmente 0, luego se actualizará
                    'detalle' => []
                ];
            }

            $detalle = [
                'id' => $ticket['detalle_id'],
                'producto_nombre' => $ticket['producto_nombre'],
                'producto_marca' => $ticket['producto_marca'],
                'producto_descripcion' => $ticket['producto_descripcion'],
                'servicio_nombre' => $ticket['servicio_nombre'],
                'servicio_descripcion' => $ticket['servicio_descripcion'],
                'cantidad' => $ticket['cantidad'],
                'precio' => $ticket['precio']
            ];

            $formatted[$factura_id]['detalle'][] = $detalle;

            // Calcular el total sumando el precio * cantidad de cada detalle
            $formatted[$factura_id]['total'] += $ticket['precio'] * $ticket['cantidad'];
        }

        // Convertir el array de facturas a un formato indexado
        return array_values($formatted);
    }
}
?>
