using api_rest.Entities;
using Microsoft.EntityFrameworkCore;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace api_rest.Context
{
    public class AppDbContext : DbContext
    {

        public AppDbContext(DbContextOptions<AppDbContext> options) : base(options)
        {

        }

        public DbSet<Usuario> Usuarios { get; set; }
        public DbSet<Estilo> Estilos { get; set; }
        public DbSet<Imagen> Imagenes { get; set; }
        public DbSet<Marca> Marcas { get; set; }
        public DbSet<Modelo> Modelos { get; set; }
        public DbSet<Motor> Motores { get; set; }
        public DbSet<VehiculoOfrecido> VehiculosOfrecidos { get; set;}
        public DbSet<VehiculoDeseado> VehiculosDeseados { get; set;}
        public DbSet<Color> Colores { get; set; }
     

     

    }
}
