using System;
using System.Collections.Generic;
using System.Text;

namespace BarberiaApp.Models
{
    public class Cita
    {
        public int Id { get; set; }
        public Cliente Cliente { get; set; }
        public Barbero Barbero { get; set; }
        public Corte Corte { get; set; }
        public Barberia Barberia { get; set; }

        public DateTime Fecha { get; set; }
        public string Hora { get; set; }
        public 

    }
}
