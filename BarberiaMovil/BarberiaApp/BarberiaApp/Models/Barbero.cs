using System;
using System.Collections.Generic;
using System.Text;

namespace BarberiaApp.Models
{
    public class Barbero
    {
        public int Id { get; set; }
        public string Nombre { get; set; }
        public string Apellidos { get; set; }
        public string Apodo { get; set; }
        public string Correo { get; set; }
        public string Telefono { get; set; }
        public string Password { get; set; }

        public Barberia idBarberia { get; set; }
    }
}
