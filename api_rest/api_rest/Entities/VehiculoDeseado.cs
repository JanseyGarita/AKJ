using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Threading.Tasks;

namespace api_rest.Entities
{
    public class VehiculoDeseado
    {
      
        [Key]
        public int id { get; set; }
        public int id_vehiculo { get; set; }
        public int id_usuario { get; set; }

        
    }
}
