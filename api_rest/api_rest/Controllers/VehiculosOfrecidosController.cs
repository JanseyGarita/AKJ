using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using api_rest.Context;
using api_rest.Entities;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;

// For more information on enabling Web API for empty projects, visit https://go.microsoft.com/fwlink/?LinkID=397860

namespace api_rest.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class VehiculosOfrecidosController : ControllerBase
    {

        private readonly AppDbContext context;

        public VehiculosOfrecidosController(AppDbContext context)
        {
            this.context = context;
        }
        // GET: api/<VehiculosOfrecidosController>
        [HttpGet]
        public IEnumerable<VehiculoOfrecido> Get()
        {
            return context.VehiculosOfrecidos.FromSqlRaw("Select * from dbo.vw_get_vehiculos_ofrecidos").ToList();
        }

        // GET api/<VehiculosOfrecidosController>/5
        [HttpGet("{id}")]
        public VehiculoOfrecido Get(int id)
        {
            return context.VehiculosOfrecidos.FromSqlRaw("dbo.sp_get_vehiculo_ofrecido {0}", id).ToList().FirstOrDefault();
        }


        // POST api/<VehiculosOfrecidosController>
        [HttpPost]
        public ActionResult Post([FromBody] VehiculoOfrecido vehiculo)
        {

            try
            {
                context.Database.ExecuteSqlRaw("dbo.sp_insert_vehiculos_ofrecidos {0}, {1}, {2}, {3}, {4}, {5}, {6}, {7}, {8}, {9}, {10}, {11}," +
                    " {12}, {13}, {14}", vehiculo.precio, vehiculo.año, vehiculo.combustible, vehiculo.cant_puertas,
                    vehiculo.transmision, vehiculo.negociable, vehiculo.recibe, vehiculo.vendido,
                    vehiculo.id_marca,vehiculo.id_color_exterior, vehiculo.id_color_interior, vehiculo.id_modelo, 
                    vehiculo.id_estilo, vehiculo.id_motor, vehiculo.id_usuario);
                return Ok();
            }
            catch
            {

                return BadRequest();
            }
        }

        // PUT api/<VehiculosOfrecidosController>/5
        [HttpPut("{id}")]
        public ActionResult Put(int id, [FromBody] VehiculoOfrecido vehiculo)
        {
            try
            {
                if (vehiculo.id == id)
                {


                   context.Database.ExecuteSqlRaw("dbo.sp_update_vehiculos_ofrecidos {0}, {1}, {2}, {3}, {4}, {5}, {6}, {7}, {8}, {9}, {10}, {11}," +
                   " {12}, {13}, {14}, {15}",id , vehiculo.precio, vehiculo.año, vehiculo.combustible, vehiculo.cant_puertas,
                   vehiculo.transmision, vehiculo.negociable, vehiculo.recibe, vehiculo.vendido,
                   vehiculo.id_marca, vehiculo.id_color_exterior, vehiculo.id_color_interior, vehiculo.id_modelo,
                   vehiculo.id_estilo, vehiculo.id_motor, vehiculo.id_usuario);

                    return Ok();
                }
                else
                {
                    return BadRequest();
                }
            }
            catch
            {
                return BadRequest();
            }
        }

        // DELETE api/<VehiculosOfrecidosController>/5
        [HttpDelete("{id}")]
        public ActionResult Delete(int id)
        {

            try
            {
                context.Database.ExecuteSqlRaw("dbo.sp_delete_vehiculos_ofrecidos {0}", id);
                return Ok();

            }
            catch
            {
                return BadRequest();

            }
        }
    }
}
