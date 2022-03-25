using BarberiaApp.Enums;
using System;
using System.Collections.Generic;
using System.Text;

namespace BarberiaApp.Models
{
    public class Barberia
    {
        public int Id { get; set; }
        public string Nombre { get; set; }
        public string Direccion { get; set; }
        public string Telefono { get; set; }
        public string Correo { get; set; }
        public string Horario { get; set; }
        public EstadoBarberia EstadoBarberia { get; set; }


    }
}
