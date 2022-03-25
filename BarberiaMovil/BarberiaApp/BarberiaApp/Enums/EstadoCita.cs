using System;
using System.Collections.Generic;
using System.Text;

namespace BarberiaApp.Enums
{
    public enum EstadoCita
    {
        Pendiente, Realizada, Cancelada
    }

    public class enumeradoes
    {
        public static EstadoCita ObtenerEstado(int numero){
            if (numero == 1)
            {
                return EstadoCita.Pendiente;
            }
            else if(numero == 2){
                return EstadoCita.Realizada;
            }
            else
            {
                return EstadoCita.Cancelada;
            }
        }
    }
}
