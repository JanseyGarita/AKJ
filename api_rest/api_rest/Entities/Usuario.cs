using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Threading.Tasks;

namespace api_rest.Entities
{
    public class Usuario
    {
        [Key]
        public int id { get; set; }
        public string nombre { get; set; }
        public string correo { get; set; }
        public string telefono { get; set; }
        public string direccion { get; set; }
        public string foto { get; set; }
        public string contraseña { get; set; }


       
     
    }
}
