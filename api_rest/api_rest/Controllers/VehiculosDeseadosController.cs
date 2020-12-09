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
    public class VehiculosDeseadosController : ControllerBase
    {

        private readonly AppDbContext context;

        public VehiculosDeseadosController(AppDbContext context)
        {
            this.context = context;
        }
        // GET: api/<VehiculosDeseadosController>
        [HttpGet]
        public IEnumerable<VehiculoDeseado> Get()
        {
            return context.VehiculosDeseados.FromSqlRaw("Select * from dbo.vw_get_vehiculos_deseados").ToList();
        }

        // GET api/<VehiculosDeseadosController>/5
        [HttpGet("{id}")]
        public VehiculoDeseado Get(int id)
        {
            return context.VehiculosDeseados.FromSqlRaw("dbo.sp_get_vehiculo_deseado {0}", id).ToList().FirstOrDefault();
        }

        // POST api/<VehiculosDeseadosController>
        [HttpPost]
        public ActionResult Post([FromBody] VehiculoDeseado vehiculo)
        {
            try
            {
                context.Database.ExecuteSqlRaw("dbo.sp_insert_vehiculos_deseados {0}, {1}",
                vehiculo.id_vehiculo,vehiculo.id_usuario);
                return Ok();
            }
            catch
            {

                return BadRequest();
            }
        }

        // PUT api/<VehiculosDeseadosController>/5
        [HttpPut("{id}")]
        public ActionResult Put(int id, [FromBody] VehiculoDeseado vehiculo)
        {
            if (id == vehiculo.id)
            {
                context.Database.ExecuteSqlRaw("dbo.sp_update_vehiculos_deseados {0}, {1}, {2}",
                   id,vehiculo.id_vehiculo, vehiculo.id_usuario);
                return Ok();
            }
            else
            {
                return BadRequest();
            }
        }

        // DELETE api/<VehiculosDeseadosController>/5
        [HttpDelete("{id}")]
        public ActionResult Delete(int id)
        {
            try
            {
                context.Database.ExecuteSqlRaw("dbo.sp_delete_vehiculos_deseados {0}", id);
                return Ok();

            }
            catch
            {
                return BadRequest();

            }
        }
    }
}
