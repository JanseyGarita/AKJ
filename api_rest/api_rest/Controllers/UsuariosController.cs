using System;
using System.Collections.Generic;
using System.Linq;
using System.Reflection.Metadata;
using System.Security.Cryptography;
using System.Text;
using System.Threading.Tasks;
using api_rest.Context;
using api_rest.Entities;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Data.SqlClient;
using Microsoft.EntityFrameworkCore;
using Microsoft.EntityFrameworkCore.Query.Internal;

// For more information on enabling Web API for empty projects, visit https://go.microsoft.com/fwlink/?LinkID=397860

namespace api_rest.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class UsuariosController : ControllerBase
    {

        private readonly AppDbContext context;

        public UsuariosController(AppDbContext context)
        {
            this.context = context;
        }


        // GET: api/<UsuariosController>
        [HttpGet]
        public IEnumerable<Usuario> Get()
        {
            return context.Usuarios.FromSqlRaw("Select * from dbo.vw_get_usuarios").ToList() ;
        
        }

        // GET api/<UsuariosController>/5
        [HttpGet("{correo}")]
        public Usuario Get(string correo)
        {
            return context.Usuarios.FromSqlRaw("dbo.sp_get_usuario {0}", correo).ToList().FirstOrDefault();
        }

        // POST api/<UsuariosController>
        [HttpPost]
        public ActionResult Post([FromBody] Usuario usuario)
        {
            try {   
                context.Database.ExecuteSqlRaw("dbo.sp_insert_usuarios @p0,@p1,@p2,@p3,@p4,@p5",
                 parameters: new[] { usuario.nombre, usuario.correo, usuario.telefono, usuario.direccion,usuario.foto, usuario.contraseña });
                
                return Ok();
            } catch {
                return BadRequest();
            }

           
        }

        // PUT api/<UsuariosController>/5
        [HttpPut("{id}")]
        public ActionResult Put(int id, [FromBody] Usuario usuario)
        {
            try {
                if (usuario.id == id)
                {

               
                      context.Database.ExecuteSqlRaw("dbo.sp_update_usuarios {0}, {1}, {2}, {3}, {4}, {5}, {6}",
                      id, usuario.nombre, usuario.correo, usuario.telefono, usuario.direccion, usuario.foto, usuario.contraseña);

                    return Ok();
                }
                else {
                    return BadRequest();
                }
            } catch {
                return BadRequest();
            }


        }

        // DELETE api/<UsuariosController>/5
        [HttpDelete("{id}")]
        public ActionResult Delete(int id)
        {


            try
            {
                context.Database.ExecuteSqlRaw("dbo.sp_delete_usuarios {0}",id );
                return Ok();

            }
            catch{
                return BadRequest();

            }
        }

        public string ComputeHash(string input, HashAlgorithm algorithm)
        {
            Byte[] inputBytes = Encoding.UTF8.GetBytes(input);

            Byte[] hashedBytes = algorithm.ComputeHash(inputBytes);

            return BitConverter.ToString(hashedBytes);
        }
    }
}
