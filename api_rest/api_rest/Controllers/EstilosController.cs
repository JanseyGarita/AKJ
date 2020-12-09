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
    public class EstilosController : ControllerBase
    {

        private readonly AppDbContext context;

        public EstilosController(AppDbContext context)
        {
            this.context = context;
        }
        // GET: api/<EstilosController>
        [HttpGet]
        public IEnumerable<Estilo> Get()
        {
            return context.Estilos.FromSqlRaw("Select * from dbo.vw_get_estilos").ToList();
        }

        // GET api/<EstilosController>/5
        [HttpGet("{nombre}")]
        public Estilo Get(string nombre)
        {
            return context.Estilos.FromSqlRaw("dbo.sp_get_estilo_by_name {0}", nombre).ToList().FirstOrDefault();
        }

        // POST api/<EstilosController>
        [HttpPost]
        public ActionResult Post([FromBody] Estilo estilo)
        {

            try
            {
                context.Database.ExecuteSqlRaw("dbo.sp_insert_estilos @p0",
                 parameters: new[] { estilo.nombre });
                return Ok();
            }
            catch
            {

                return BadRequest();
            }


        }

        // PUT api/<EstilosController>/5
        [HttpPut("{id}")]
        public ActionResult Put(int id, [FromBody] Estilo estilo)
        {
            if (id == estilo.id)
            {
                context.Database.ExecuteSqlRaw("dbo.sp_update_estilos {0}, {1}",
                   id, estilo.nombre);
                return Ok();
            }
            else
            {
                return BadRequest();
            }

        }

        // DELETE api/<EstilosController>/5
        [HttpDelete("{id}")]
        public ActionResult Delete(int id)
        {
            try
            {
                context.Database.ExecuteSqlRaw("dbo.sp_delete_estilos {0}",id);
                return Ok();

            }
            catch
            {
                return BadRequest();

            }
        }
    }
}
