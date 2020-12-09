using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Threading.Tasks;

namespace api_rest.Entities
{
    public class Color
    {

        [Key]
        public int id { get; set; }
        public string color { get; set; }
        public string hex_color { get; set; }



    }
}
