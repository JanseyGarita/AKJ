using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Threading.Tasks;

namespace api_rest.Entities
{
    public class Motor
    {

        [Key]
        public int id { get; set; }
        public string cilindraje { get; set; }
         
    }
}
