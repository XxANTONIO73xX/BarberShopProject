using System;
using System.Collections.Generic;
using System.Text;

namespace BarberiaApp.Enums
{
    public enum EstadoBarberia
    {
        Abierto, Cerrado
    }

    public class enumeradores
    {
        public static EstadoBarberia ObtenerEstado(int numero)
        {
            if (numero == 1)
            {
                return EstadoBarberia.Abierto;
            }
            else
            {
                return EstadoBarberia.Cerrado;
            }
        }
    }
    
}
