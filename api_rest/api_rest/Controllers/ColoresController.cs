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
    public class ColoresController : ControllerBase
    {

        private readonly AppDbContext context;

        public ColoresController(AppDbContext context)
        {
            this.context = context;
        }

        // GET: api/<ColoresController>
        [HttpGet]
        public IEnumerable<Color> Get()
        {
            return context.Colores.FromSqlRaw("Select * from dbo.vw_get_colores").ToList();
        }


        // GET api/<ColoresController>/5
        //[HttpGet("{id}")]
        //public Color Get(int id)
        //{
           // return context.Colores.FromSqlRaw("dbo.sp_get_color {0}", id).ToList().FirstOrDefault();
        //}


        // GET api/<ColoresController>/5
        [HttpGet("{color}")]
        public Color Get(string color)
        {
            return context.Colores.FromSqlRaw("dbo.sp_get_color_by_color {0}", color).ToList().FirstOrDefault();
        }

        // POST api/<ColoresController>
        [HttpPost]
        public ActionResult Post([FromBody] Color color)
        {
            try
            {

                context.Database.ExecuteSqlRaw("dbo.sp_insert_colores @p0,@p1",
                 parameters: new[] { color.color,color.hex_color });

                return Ok();
            }
            catch
            {
                return BadRequest();
            }


        }

        // PUT api/<ColoresController>/5
        [HttpPut("{id}")]
        public ActionResult Put(int id, [FromBody] Color color)
        {

            try
            {
                if (color.id == id)
                {


                    context.Database.ExecuteSqlRaw("dbo.sp_update_colores {0}, {1}, {2}",
                    id, color.color, color.hex_color);

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

        // DELETE api/<ColoresController>/5
        [HttpDelete("{id}")]
        public ActionResult Delete(int id)
        {

            try
            {
                context.Database.ExecuteSqlRaw("dbo.sp_delete_colores {0}", id);
                return Ok();

            }
            catch
            {
                return BadRequest();

            }
        }
    }
}
