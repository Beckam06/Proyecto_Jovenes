<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario admin
        DB::table('users')->insertOrIgnore([
            'id'         => 1,
            'name'       => 'Administrador',
            'email'      => 'admin@jec',
            'password'   => '$2y$12$YiKjFtSOblTs4N6/vvL6b.xNYXKKWLxWF0WaTQBqDS/tXX.H/cnP6',
            'created_at' => '2025-10-31 00:59:58',
            'updated_at' => '2025-10-31 00:59:58',
        ]);

        // Productos
        $products = [
            [1,'PAPEL HIGIENICO (MEMBERS SELECTION)','PAQUETE DE 4 ROLLOS',33,'PROD001'],
            [2,'PAPEL TOALLA (MEMBERS SELECTION)','ROLLO',10,'PROD002'],
            [3,'PAPEL ALUMINIO (MEMBERS SELECTION)','CAJA DE 300 PIES',2,'PROD003'],
            [4,'PAPEL ALUMINIO (MEMBERS SELECTION)','CAJA DE 1000 PIES',0,'PROD004'],
            [5,'PAPEL PARA ENVOLVER (MEMBERS SELECTION)','CAJA DE 2000 PIES',6,'PROD005'],
            [6,'SERVILLETAS','PAQUETE',9,'PROD006'],
            [7,'TOALLAS PARA DESINFECTAR (CLOROX)','BOTE',3,'PROD007'],
            [8,'PASTA DE DIENTES 75 ML (COLGATE)','UNIDAD',12,'PROD008'],
            [9,'PASTA DE PARA NIÑOS (COLGATE)','UNIDAD',1,'PROD009'],
            [10,'LIQUIDO PARA VIDRIOS','BOTE',4,'PROD010'],
            [11,'ACEITE ROJO','BOTE',2,'PROD011'],
            [12,'DESODORANTE (DEGREE)','UNIDAD',8,'PROD012'],
            [13,'DESODORANTE (OLD SPICE)','UNIDAD',6,'PROD013'],
            [14,'DESODORANTE (REXONA)','UNIDAD',2,'PROD014'],
            [15,'DESINFECTANTE (FABULOSO)','GALON',6,'PROD015'],
            [16,'CLORO (MEMBERS SELECTION)','GALON',7,'PROD016'],
            [17,'SUAVISANTE DE ROPA (MEMBERS SELECTION)','GALON',0,'PROD017'],
            [18,'DETERGENTE (ULTRA KLIN)','BOLSA DE 5 KG',1,'PROD018'],
            [19,'DETERGENTE (MEMBERS SELEC)','BOLSA DE 22 LBS',1,'PROD019'],
            [20,'TALCOS (ODORIT)','BOTE',5,'PROD020'],
            [21,'CREMA PARA CUERPO (ALOE VERA)','BOTE',2,'PROD021'],
            [22,'CREMA PARA CUERPO (SUAVE)','BOTE',2,'PROD022'],
            [23,'LIMPIADOR MULTIUSOS (AJAX)','BOTE',5,'PROD023'],
            [24,'PASTE VERDE','UNIDAD',30,'PROD024'],
            [25,'PASTE DE METAL (SCOTT)','UNIDAD',11,'PROD025'],
            [26,'JABON PARA PLATOS (MEMBERS SELEC)','PANA',35,'PROD026'],
            [27,'JABON DE BAÑO (PROTEX)','BARRA',9,'PROD027'],
            [28,'JABON LIQUIDO PARA MANOS (MORE ESSENTIAL)','GALON',2,'PROD028'],
            [29,'JABON PARA ROPA (MAX)','BARRA',16,'PROD029'],
            [30,'CHINOLA GRANDE (DIAMOND)','LATA',6,'PROD030'],
            [31,'CEPILLO PARA ZAPATOS','UNIDAD',5,'PROD031'],
            [32,'CEPILLO DE DIENTES ADULTO','UNIDAD',0,'PROD032'],
            [33,'CEPILLO DE DIENTES NIÑO','UNIDAD',0,'PROD033'],
            [34,'GANCHOS PARA ROPA','BOLSA',3,'PROD034'],
            [35,'ESPONJA DE BAÑO','UNIDAD',0,'PROD035'],
            [36,'CORTA UÑAS','UNIDAD',0,'PROD036'],
            [37,'PRESTOBARBA','UNIDAD',0,'PROD037'],
            [38,'TAZAS PARA SOPA','PAQUETE DE 25 TAZAS',3,'PROD038'],
            [39,'VASOS #10','PAQUETE',2,'PROD039'],
            [40,'VASOS #5','PAQUETE',10,'PROD040'],
            [41,'PLATOS #9','PAQUETE',18,'PROD041'],
            [42,'PLATO #6','PAQUETE',46,'PROD042'],
            [43,'TENEDORES','PAQUETE',14,'PROD043'],
            [44,'CUCHARAS','PAQUETE',12,'PROD044'],
            [45,'BOLSA CLARA PARA BASURA','ROLLO DE 125 BOLSAS',3,'PROD045'],
            [46,'BOLSA NEGRA GRANDE BARRIL','ROLLO DE 25 BOLSAS',2,'PROD046'],
            [47,'BOLSA BLANCA MEDIANA AGARRE','ROLLO DE 80 BOLSAS',2,'PROD047'],
            [48,'BOLSAS 4*8','PAQUETE',18,'PROD048'],
            [49,'BOLSAS 5*11','PAQUETE',2,'PROD049'],
            [50,'BOLSAS 9*16','PAQUETE',3,'PROD050'],
            [51,'BOLSA TIPO CAMISETA','PAQUETE',0,'PROD051'],
            [52,'BOLSA CLARA','ROLLO',0,'PROD052'],
            [53,'BOLSA ZIPLOCK','CAJA',0,'PROD053'],
            [54,'PASTILLAS AROMATIZANTES (TERROR)','UNIDAD',19,'PROD054'],
            [55,'CREMA PARA CABELLO (NUTRINE)','BOTE',4,'PROD055'],
            [56,'GELATINA PARA CABELLO (EGO)','BOTE DE 1000 ML',1,'PROD056'],
            [57,'GELATINA PARA CABELLO (NUTRINE)','BOTE 250 GR.',4,'PROD057'],
            [58,'HISOPOS','CAJA DE 150 UNID',7,'PROD058'],
            [59,'MECHA PARA TRAPEADOR','UNIDAD',5,'PROD059'],
            [60,'RECOGEDOR PARA BASURA','UNIDAD',9,'PROD060'],
            [61,'ESCOBAS (KIKA)','UNIDAD',12,'PROD061'],
            [62,'CEPILLO PARA BAÑO','UNIDAD',10,'PROD062'],
            [63,'CEPILLO PARA PILA','UNIDAD',2,'PROD063'],
            [64,'DESTAPACAÑOS','UNIDAD',3,'PROD064'],
            [65,'PALO PARA TRAPEADOR','UNIDAD',16,'PROD065'],
            [66,'FRANELAS','UNIDAD',25,'PROD066'],
            [67,'GUANTES AMARILLOS','PAQUETE TALLA M',3,'PROD067'],
            [68,'GUANTES AMARILLOS','PAQUETE TALLA L',3,'PROD068'],
            [69,'AMBIENTADOR (GLADE)','BOTE',10,'PROD069'],
            [70,'DESINFECTANTE EN AEROSOL (LYSOL)','BOTE',0,'PROD070'],
            [71,'LAMINITAS (RAID)','CAJA',12,'PROD071'],
            [72,'LAMINITAS CON MAQUINA (RAID)','CAJA',0,'PROD072'],
            [73,'REPELENTE (OFF)','BOTE EN SPRAY',2,'PROD073'],
            [74,'REPELENTE (OFF)','BOTE EN CREMA DE 60 GR.',3,'PROD074'],
            [75,'INSECTICIDA (RAID MAX)','BOTE',4,'PROD075'],
            [76,'BASUREROS','UNIDAD',0,'PROD076'],
        ];

        foreach ($products as $p) {
            DB::table('products')->insertOrIgnore([
                'id'          => $p[0],
                'name'        => $p[1],
                'description' => $p[2],
                'price'       => 0,
                'stock'       => $p[3],
                'sku'         => $p[4],
                'created_at'  => '2025-10-31 01:00:55',
                'updated_at'  => '2025-10-31 01:00:55',
            ]);
        }
    }
}
