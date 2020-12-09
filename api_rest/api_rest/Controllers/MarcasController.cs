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
    public class MarcasController : ControllerBase
    {

        private readonly AppDbContext context;

        public MarcasController(AppDbContext context)
        {
            this.context = context;
        }
        // GET: api/<MarcasController>
        [HttpGet]
        public IEnumerable<Marca> Get()
        {
            return context.Marcas.FromSqlRaw("Select * from dbo.vw_get_marcas").ToList();
        }

        // GET api/<MarcasController>/5
      //  [HttpGet("{id}")]
      //  public Marca Get(int id)
       // {
        //    return context.Marcas.FromSqlRaw("dbo.sp_get_marca {0}", id).ToList().FirstOrDefault();
        //}

        // GET api/<MarcasController>/5
        [HttpGet("{marca}")]
        public Marca Get(String marca)
        {
            return context.Marcas.FromSqlRaw("dbo.sp_get_marca_by_name {0}", marca).ToList().FirstOrDefault();
        }

        // POST api/<MarcasController>
        [HttpPost]
        public ActionResult Post([FromBody] Marca marca)
        {
            try
            {
                context.Database.ExecuteSqlRaw("dbo.sp_insert_marcas {0}",
                marca.nombre);
                return Ok();
            }
            catch
            {

                return BadRequest();
            }
        }

        // PUT api/<MarcasController>/5
        [HttpPut("{id}")]
        public ActionResult Put(int id, [FromBody] Marca marca)
        {
            if (id == marca.id)
            {
                context.Database.ExecuteSqlRaw("dbo.sp_update_marcas {0}, {1}",
                   id, marca.nombre);
                return Ok();
            }
            else
            {
                return BadRequest();
            }
        }

        // DELETE api/<MarcasController>/5
        [HttpDelete("{id}")]
        public ActionResult Delete(int id)
        {

            try
            {
                context.Database.ExecuteSqlRaw("dbo.sp_delete_marcas {0}", id);
                return Ok();

            }
            catch
            {
                return BadRequest();

            }
        }
    }
}
