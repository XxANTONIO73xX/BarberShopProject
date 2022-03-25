using System;
using System.Collections.Generic;
using System.Text;

namespace BarberiaApp.Models
{
    public class Cliente
    {
        public int Id { get; set; }
        public string Nombre { get; set; }
        public string Apellidos { get; set; }
        public string Correo { get; set; }
        public string Telefono { get; set; }
        public string Password { get; set; }

    }
}
