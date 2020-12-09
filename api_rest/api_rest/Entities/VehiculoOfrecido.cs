using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Threading.Tasks;

namespace api_rest.Entities
{
    public class VehiculoOfrecido
    {


        [Key]
        public int id { get; set; }
        public string precio { get; set; }
        public string año { get; set; }
        public string combustible { get; set; }
        public string cant_puertas { get; set; }
        public string transmision { get; set; }
        public bool negociable { get; set; }
        public DateTime creado_en { get; set; }
        public bool recibe { get; set; }
        public bool vendido { get; set; }


        public int? id_marca { get; set; }

        public int? id_color_exterior { get; set; }
        public int? id_color_interior { get; set; }
        public int? id_modelo { get; set; }
        public int? id_estilo { get; set; }
        public int? id_motor { get; set; }
        public int? id_usuario { get; set; }

        public string marca { get; set; }
        public string color_exterior { get; set; }
        public string color_interior { get; set; }
        public string modelo { get; set; }
        public string estilo { get; set; }
        public string motor { get; set; }
       




    }
}
