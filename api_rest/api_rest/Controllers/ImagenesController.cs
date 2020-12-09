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
    public class ImagenesController : ControllerBase
    {

        private readonly AppDbContext context;

        public ImagenesController(AppDbContext context)
        {
            this.context = context;
        }
        // GET: api/<ImagenesController>
        [HttpGet]
        public IEnumerable<Imagen> Get()
        {
            return context.Imagenes.FromSqlRaw("Select * from dbo.vw_get_imagenes").ToList();
        }

        // GET api/<ImagenesController>/5
        [HttpGet("{id_car}")]
        public IEnumerable<Imagen> Get(int id_car)
        {
            return context.Imagenes.FromSqlRaw("dbo.sp_get_imagenes_id_carro {0}", id_car).ToList();
        }

        // POST api/<ImagenesController>
        [HttpPost]
        public ActionResult Post([FromBody] Imagen imagen)
        {

            try
            {
                  context.Database.ExecuteSqlRaw("dbo.sp_insert_imagenes {0}, {1}",
                  imagen.url, imagen.id_vehiculo );
                return Ok();
            }
            catch
            {

                return BadRequest();
            }
        }

        // PUT api/<ImagenesController>/5
        [HttpPut("{id}")]
        public ActionResult Put(int id, [FromBody] Imagen imagen)
        {

            if (id == imagen.id_imagen)
            {
                context.Database.ExecuteSqlRaw("dbo.sp_update_imagenes {0}, {1}, {2}",
                   id, imagen.url, imagen.id_vehiculo);
                return Ok();
            }
            else
            {
                return BadRequest();
            }
        }

        // DELETE api/<ImagenesController>/5
        [HttpDelete("{id}")]
        public ActionResult Delete(int id)
        {
            try
            {
                context.Database.ExecuteSqlRaw("dbo.sp_delete_imagen {0}", id);
                return Ok();

            }
            catch
            {
                return BadRequest();

            }
        }
    }
}
