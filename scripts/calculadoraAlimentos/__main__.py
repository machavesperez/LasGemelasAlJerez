import sys					# Listar argumentos introducidos al ejecutar el script: https://www.tutorialspoint.com/python/python_command_line_arguments.htm
import getopt				# Exception getopt.GetoptError, lanzada cuando se encuentra una opcion no reconocida en la lista de argumentos o no se especifica un argumento necesario
import os

from . import calculadora 	# Funciones de calculadora
from . import excel 		# Funciones para imprimir XLSXs
from . import pdf 			# Funciones para imprimir PDFs

# Eliminar ficheros temporales
def deleteFicheros ():
	print ("Eliminando ficheros temporales")
	try:
		os.remove('evento.xlsx') 
	except:
		pass

	try:
		os.remove('menu.xlsx')
	except:
		pass

	try:
		os.remove('receta.xlsx')
	except:
		pass

	try:
		os.remove('output.xlsx')
	except:
		pass



## START MAIN ## 
def main (argv):
	global SQLstarted
	global cnx
	global cursor

	str_funcion = str(argv[0]).lower()
	int_id 		= int(argv[1])

	print ("Resultado de " + str_funcion + '(' + str(int_id) + ')' )


	calculadora.beginSQL(True)

	if (str_funcion == "listaCompraEvento".lower()):
		excel.eventoToExcel(int_id)
		pdf.printListaCompraEvento()
	elif (str_funcion == "listaCompraMenu".lower()):
		excel.menuToExcel(int_id)
		pdf.printListaCompraMenu()
	elif (str_funcion == "listaCompraReceta".lower()):
		excel.recetaToExcel(int_id)
		pdf.printListaCompraReceta()
	elif (str_funcion == "beneficioEvento".lower()):
		excel.eventoToExcel(int_id)
		pdf.printBeneficioEvento()
	elif (str_funcion == "beneficioMenu".lower()):
		excel.menuToExcel(int_id)
		pdf.printBeneficioMenu()
	elif (str_funcion == "beneficioReceta".lower()):
		excel.recetaToExcel(int_id)
		pdf.printBeneficioReceta()

	calculadora.beginSQL(False)


	# Eliminar ficheros temporales
	# De no hacerlo los excels pueden estar corruptos y las columnas cambiadas de sitio
	#deleteFicheros()


if __name__ == "__main__":
	global SQLstarted
	global cnx
	global cursor
	print ("python calculadoraAlimentos.__main__ <nombreFuncion> <id>")
	print ("Ejemplo:")
	print ("\t python calculadoraAlimentos listaCompraEvento 2")
	main(sys.argv[1:])

## END MAIN ##



#print ('Number of arguments: ', len(sys.argv), " arguments.")
#print ('Argument List: ', str(sys.argv))
#print(sys.argv[1])


# try:
# 	opts, args = getopt.getopt(argv, )
# except getopt.GetoptError:
# 	print ("python calculadoraAlimentos <nombreFuncion> <id>")
# 	print ("Ejemplo:")
# 	print ("\t python calculadoraAlimentos listaCompraEvento 2")
# 	sys.exit(2)

# for opt, arg, in opts:
# 	if opt