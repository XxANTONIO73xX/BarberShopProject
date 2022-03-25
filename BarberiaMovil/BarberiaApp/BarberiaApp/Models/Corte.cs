using System;
using System.Collections.Generic;
using System.Text;

namespace BarberiaApp.Models
{
    public class Corte
    {
        public int Id { get; set; }
        public string Nombre { get; set; }
        public string Visualizacion { get; set; }
        public Barbero Barbero { get; set; }
    }
}
