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
    public class MotoresController : ControllerBase
    {

        private readonly AppDbContext context;

        public MotoresController(AppDbContext context)
        {
            this.context = context;
        }
        // GET: api/<MotoresController>
        [HttpGet]
        public IEnumerable<Motor> Get()
        {
        return context.Motores.FromSqlRaw("Select * from dbo.vw_get_motores").ToList(); 
        }

        // GET api/<MotoresController>/5
        [HttpGet("{cilindraje}")]
        public Motor Get(string cilindraje)
        {
            return context.Motores.FromSqlRaw("dbo.sp_get_motor_by_cilindraje {0}",cilindraje).ToList().FirstOrDefault();
        }

        // POST api/<MotoresController>
        [HttpPost]
        public ActionResult Post([FromBody] Motor motor)
        {
            try
            {
                context.Database.ExecuteSqlRaw("dbo.sp_insert_motores {0}",
                motor.cilindraje);
                return Ok();
            }
            catch
            {

                return BadRequest();
            }
        }

        // PUT api/<MotoresController>/5
        [HttpPut("{id}")]
        public ActionResult Put(int id, [FromBody] Motor motor)
        {
            if (id == motor.id)
            {
                context.Database.ExecuteSqlRaw("dbo.sp_update_motores {0}, {1}",
                   id, motor.cilindraje);
                return Ok();
            }
            else
            {
                return BadRequest();
            }
        }

        // DELETE api/<MotoresController>/5
        [HttpDelete("{id}")]
        public ActionResult Delete(int id)
        {
            try
            {
                context.Database.ExecuteSqlRaw("dbo.sp_delete_motores {0}", id);
                return Ok();

            }
            catch
            {
                return BadRequest();

            }
        }
    }
}
