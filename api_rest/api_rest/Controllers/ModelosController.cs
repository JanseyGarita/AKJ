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
    public class ModelosController : ControllerBase
    {


        private readonly AppDbContext context;

        public ModelosController(AppDbContext context)
        {
            this.context = context;
        }
        // GET: api/<ModelosController>
        [HttpGet]
        public IEnumerable<Modelo> Get()
        {
            return context.Modelos.FromSqlRaw("Select * from dbo.vw_get_modelos").ToList(); 
        }

        // GET api/<ModelosController>/5
      //  [HttpGet("{id}")]
       // public Modelo Get(int id)
       // {
         //   return context.Modelos.FromSqlRaw("dbo.sp_get_modelo {0}",id).ToList().FirstOrDefault();
       // }



        // GET api/<ModelosController>/5
        [HttpGet("{modelo}")]
        public Modelo Get(string modelo)
        {
            return context.Modelos.FromSqlRaw("dbo.sp_get_modelo_by_name {0}", modelo).ToList().FirstOrDefault();
        }

        // POST api/<ModelosController>
        [HttpPost]
        public ActionResult Post([FromBody] Modelo modelo)
        {

            try
            {
                context.Database.ExecuteSqlRaw("dbo.sp_insert_modelos {0}",
                modelo.nombre);
                return Ok();
            }
            catch
            {

                return BadRequest();
            }
        }

        // PUT api/<ModelosController>/5
        [HttpPut("{id}")]
        public ActionResult Put(int id, [FromBody] Modelo modelo)
        {
            if (id == modelo.id)
            {
                context.Database.ExecuteSqlRaw("dbo.sp_update_modelos {0}, {1}",
                   id, modelo.nombre);
                return Ok();
            }
            else
            {
                return BadRequest();
            }
        }

        // DELETE api/<ModelosController>/5
        [HttpDelete("{id}")]
        public ActionResult Delete(int id)
        {
            try
            {
                context.Database.ExecuteSqlRaw("dbo.sp_delete_modelos {0}", id);
                return Ok();

            }
            catch
            {
                return BadRequest();

            }
        }
    }
}
