using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Threading.Tasks;

namespace api_rest.Entities
{
    public class Imagen
    {

        [Key]
        public int id_imagen { get; set; }
        public string url { get; set; }
        public int id_vehiculo { get; set; }

    }
}
