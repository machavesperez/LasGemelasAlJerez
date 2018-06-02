
import xlsxwriter 			# Manejo de ficheros xlsx
from copy import copy 		# Función para copiar variables
from . import calculadora 	# Variables Globales: cnx, cursor
from .calculadora import * 	# Funciones: queryToDictionary, eventoToListCompra, menuToListCompra, recetaToListProductos




####################### muyyyy importanteee, coste y beneficio estan mal planteados, seria:
# coste, ganancia (bruta), beneficio (neto)
### y considerar que un evento, menu y receta tienen un precio y comensales cerrados
#######################


def example ():
	workbook = xlsxwriter.Workbook("hola.xlsx")
	worksheet = workbook.add_worksheet()

	worksheet.write('A1', 'Hello world')

	# Some data we want to write to the worksheet.
	expenses = (
	    ['Rent', 1000],
	    ['Gas',   100],
	    ['Food',  300],
	    ['Gym',    50],
	)

	# Start from the first cell. Rows and columns are zero indexed.
	row = 1
	col = 0

	# Iterate over the data and write it out row by row.
	for item, cost in (expenses):
	    worksheet.write(row, col,     item)
	    worksheet.write(row, col + 1, cost)
	    row += 1

	# Write a total using a formula.
	worksheet.write(row, 0, 'Total')
	worksheet.write(row, 1, '=SUM(B1:B4)')

	# Close workbook
	workbook.close()


# Evento: Cena de Stimey
# - Productos -
# Nombre 		Cantidad 	UnidadCompra	PrecioCompra/Unidad 	PrecioVenta/Unidad 		Coste 			Beneficio
# Solomillo  	0.45 		kg 				2.0 					3.0 					Cantidad*PCU 	Cantidad*PVU
# - Bebidas -
# Nombre 		Cantidad 	UnidadCompra	PrecioCompra/Unidad 	PrecioVenta/Unidad 		Coste 			Beneficio
# Cerveza 1.5L	20			unidad 			1 						2 						Cantidad*PCU 	Cantidad*PVU
# - Materiales -
# Nombre 		Cantidad 	UnidadCompra 	PrecioCompra/Unidad 	PrecioVenta/Unidad 		Coste 			Beneficio
# Platitos 		12			unidad 			3,0 					4,40					Cantidad*PCU 	Cantidad*PVU
# - Trabajadores - 
# Nombre 	DNI 	HorasTrabajadas  	Precio/Hora 	Coste
# Juan 		33434 		23 				5 				Horas*Precio
def eventoToExcel (id_evento: int, str_nombreFichero: str="evento.xlsx"):
	id_evento		  = str(id_evento)
	str_nombreFichero = str(str_nombreFichero)

	# Nombre del evento y columnas de caracteristicas de cada producto/bebida/material y trabajador
	calculadora.cursor.execute("SELECT titulo FROM Evento WHERE id=" + id_evento)
	str_nombreEvento  		= str(queryToDictionary(calculadora.cursor)[0]['titulo'])
	str_columnas 	  		= ['Nombre', 'Cantidad', 'UnidadCompra', 'PrecioCompra/Unidad', 'PrecioVenta/Unidad', 'Coste', 'BeneficioBruto', 'BeneficioNeto']
	str_columnasTrabajador 	= ['Nombre', 'Apellidos', 'Cargo', 'HorasTrabajadas', 'Precio/Hora', 'Coste']
	dic_printProducto 		= dict ( zip (str_columnas, 		  [None]*len(str_columnas)))
	dic_printTrabajador 	= dict ( zip (str_columnasTrabajador, [None]*len(str_columnasTrabajador)))

	# Abrir documento XLSX
	workbook  = xlsxwriter.Workbook(str_nombreFichero)
	worksheet_nombreEvento  = workbook.add_worksheet(str_nombreEvento)
	worksheet_productos  	= workbook.add_worksheet('Productos')
	worksheet_bebidas 	 	= workbook.add_worksheet('Bebidas')
	worksheet_materiales 	= workbook.add_worksheet('Materiales')
	worksheet_trabajadores 	= workbook.add_worksheet('Trabajadores')

	# Escribir titulos de caracteristicas de producto/bebida/material en fichero xlsx
	row  = int(0) 
	col  = int(0)
	for i in range(0, len(str_columnas)):
		worksheet_productos.write  (row, col, str_columnas[i])
		worksheet_bebidas.write    (row, col, str_columnas[i])
		worksheet_materiales.write (row, col, str_columnas[i])
		col += 1

	# Escribir titulos de caracteristicas de trabajadores en fichero xlsx
	row  = int(0) 
	col  = int(0)
	for i in range(0, len(str_columnasTrabajador)):
		worksheet_trabajadores.write (row, col, str_columnasTrabajador[i])
		col += 1

	# Obtener la lista de productos, bebidas, materiales y trabajadores del evento
	# dic_compra = {
	# 	"bebidas": {id: cantidad, 5: 2, 4:1}, 
	# 	"productos": {id: Magnitud(Cantidad+Unidad), 2: Peso(g=2), 5: Volumen(ml=34), 7: Unidad(u=2)},
	# 	"materiales": {id: cantidad, 5: 2, 4:1},
	# 	"trabajadores": {id: horas}
	# }
	dic_compra 	  	 = eventoToListCompra(id_evento)
	dic_productos 	 = dic_compra['productos']
	dic_bebidas   	 = dic_compra['bebidas']
	dic_materiales 	 = dic_compra['materiales']
	dic_trabajadores = dic_compra['trabajadores'] 

	# Volcar productos del evento en formato xlxs
	row = int(0)
	col = int(0)
	for id_producto in dic_productos:
		id_producto = str(id_producto)

		# Obtener el nombre del producto, la unidad de compra, el precio de compra por unidad y el precio de venta por unidad
		calculadora.cursor.execute("SELECT * FROM Producto WHERE id=" + id_producto)
		dic_Producto = queryToDictionary(calculadora.cursor)[0]

		dic_printProducto['Nombre'] 				=   str(dic_Producto['nombre'])
		dic_printProducto['UnidadCompra'] 			=   str(dic_Producto['unidad'])
		dic_printProducto['Cantidad'] 				= float(getattr(dic_productos[id_producto],dic_printProducto['UnidadCompra'])) # expresar cantidad en receta como cantidad de compra
		dic_printProducto['PrecioCompra/Unidad'] 	= float(dic_Producto['precio_unitario'])
		dic_printProducto['PrecioVenta/Unidad']		= float(dic_Producto['precio_total'])

		# Calcular coste y beneficio del producto en el evento
		dic_printProducto['Coste'] 					= float(dic_printProducto['Cantidad'] * dic_printProducto['PrecioCompra/Unidad'])
		dic_printProducto['BeneficioBruto']  		= float(dic_printProducto['Cantidad'] * dic_printProducto['PrecioVenta/Unidad'])
		dic_printProducto['BeneficioNeto']			= float(dic_printProducto['BeneficioBruto'] - dic_printProducto['Coste'])

		row += int(1)
		col  = int(0)
		for columna in str_columnas:
			worksheet_productos.write(row, col, dic_printProducto[columna])
			col += 1

	# Volcar bebidas del evento en formato xlxs
	row = int(0)
	col = int(0)
	for id_bebida in dic_bebidas:
		id_bebida = str(id_bebida)

		# Obtener el nombre de la bebida, la unidad de compra, el precio de compra por unidad y el precio de venta por unidad
		calculadora.cursor.execute("SELECT * FROM Bebida WHERE id=" + id_bebida)
		dic_Bebida = queryToDictionary(calculadora.cursor)[0]

		dic_printProducto['Nombre'] 				=   str(dic_Bebida['nombre'])
		dic_printProducto['UnidadCompra'] 			= 'unidad'
		dic_printProducto['Cantidad'] 				= float(getattr(dic_bebidas[id_bebida],dic_printProducto['UnidadCompra']))
		dic_printProducto['PrecioCompra/Unidad'] 	= float(dic_Bebida['precio_unitario'])
		dic_printProducto['PrecioVenta/Unidad']		= float(dic_Bebida['precio_total'])

		# Calcular coste y beneficio de la bebida en el evento
		dic_printProducto['Coste'] 					= float(dic_printProducto['Cantidad'] * dic_printProducto['PrecioCompra/Unidad'])
		dic_printProducto['BeneficioBruto']  		= float(dic_printProducto['Cantidad'] * dic_printProducto['PrecioVenta/Unidad'])
		dic_printProducto['BeneficioNeto']			= float(dic_printProducto['BeneficioBruto'] - dic_printProducto['Coste'])

		row += int(1)
		col  = int(0)
		for columna in str_columnas:
			worksheet_bebidas.write(row, col, dic_printProducto[columna])
			col += 1

	# Volcar materiales del evento en formato xlxs
	row = int(0)
	col = int(0)
	for id_material in dic_materiales:
		id_material = str(id_material)

		# Obtener el nombre de la bebida, la unidad de compra, el precio de compra por unidad y el precio de venta por unidad
		calculadora.cursor.execute("SELECT * FROM Material WHERE id=" + id_material)
		dic_Material = queryToDictionary(calculadora.cursor)[0]

		dic_printProducto['Nombre'] 				=   str(dic_Material['nombre'])
		dic_printProducto['UnidadCompra'] 			= 'unidad'
		dic_printProducto['Cantidad'] 				= float(getattr(dic_materiales[id_material],dic_printProducto['UnidadCompra']))
		dic_printProducto['PrecioCompra/Unidad'] 	= float(dic_Material['precio_unitario'])
		dic_printProducto['PrecioVenta/Unidad']		= float(dic_Material['precio_total'])

		# Calcular coste y beneficio del material en el evento
		dic_printProducto['Coste'] 					= float(dic_printProducto['Cantidad'] * dic_printProducto['PrecioCompra/Unidad'])
		dic_printProducto['BeneficioBruto']  		= float(dic_printProducto['Cantidad'] * dic_printProducto['PrecioVenta/Unidad'])
		dic_printProducto['BeneficioNeto']			= float(dic_printProducto['BeneficioBruto'] - dic_printProducto['Coste'])

		row += int(1)
		col  = int(0)
		for columna in str_columnas:
			worksheet_materiales.write(row, col, dic_printProducto[columna])
			col += 1

	# Volcar trabajadores del evento en formato xlxs
	row = int(0)
	col = int(0)
	for id_trabajador in dic_trabajadores:
		id_trabajador = str(id_trabajador)

		# Obtener el nombre, apellidos, cargo (tipo)
		calculadora.cursor.execute("SELECT * FROM Trabajador WHERE id=" + id_trabajador)
		dic_Trabajador = queryToDictionary(calculadora.cursor)[0]

		# Obtener el cargo del trabajador y el sueldo
		calculadora.cursor.execute("SELECT * FROM TipoTrabajador WHERE id = (SELECT id_tipo from Trabajador WHERE id = " + id_trabajador + ")")
		dic_TipoTrabajador = queryToDictionary(calculadora.cursor)[0]

		str_columnasTrabajador 	= ['Nombre', 'Apellidos', 'Cargo', 'HorasTrabajadas', 'Precio/Hora', 'Coste']

		dic_printTrabajador['Nombre'] 			=   str(dic_Trabajador['nombre'])
		dic_printTrabajador['Apellidos'] 		=   str(dic_Trabajador['apellidos'])
		dic_printTrabajador['Cargo'] 			=   str(dic_TipoTrabajador['nombre'])
		dic_printTrabajador['Precio/Hora']  	= float(dic_TipoTrabajador['sueldo'])
		dic_printTrabajador['HorasTrabajadas'] 	= float(getattr(dic_trabajadores[id_trabajador], 'unidades')) 
		
		# Calcular coste de las horas trabajadas del trabajador
		dic_printTrabajador['Coste'] 			= float(dic_printTrabajador['HorasTrabajadas'] * dic_printTrabajador['Precio/Hora'])

		row += int(1)
		col  = int(0)
		for columna in str_columnasTrabajador:
			worksheet_trabajadores.write(row, col, dic_printTrabajador[columna])
			col += 1

	# Cerrar fichero xlsx
	workbook.close()



# Menu: Boda de maria
# - Productos -
# Nombre 		Cantidad 	UnidadCompra	PrecioCompra/Unidad 	PrecioVenta/Unidad 		Coste 			Beneficio
# Solomillo  	0.45 		kg 				2.0 					3.0 					Cantidad*PCU 	Cantidad*PVU
# - Bebidas -
# Nombre 		Cantidad 	UnidadCompra	PrecioCompra/Unidad 	PrecioVenta/Unidad 		Coste 			Beneficio
# Cerveza 1.5L	20			unidad 			1 						2 						Cantidad*PCU 	Cantidad*PVU
def menuToExcel (id_menu: int, str_nombreFichero: str="menu.xlsx"):
	id_menu 		  = str(id_menu)
	str_nombreFichero = str(str_nombreFichero)

	# Nombre del menu y columnas de caracteristicas de cada producto/bebida
	calculadora.cursor.execute("SELECT nombre FROM Menu WHERE id=" + id_menu)
	str_nombreMenu  = str(queryToDictionary(calculadora.cursor)[0]['nombre'])
	str_columnas 	  = ['Nombre', 'Cantidad', 'UnidadCompra', 'PrecioCompra/Unidad', 'PrecioVenta/Unidad', 'Coste', 'BeneficioBruto', 'BeneficioNeto']
	dic_printProducto = dict ( zip (str_columnas, [None]*len(str_columnas)))

	# Abrir documento XLSX
	workbook  = xlsxwriter.Workbook(str_nombreFichero)
	worksheet_nombreMenu  = workbook.add_worksheet(str_nombreMenu)
	worksheet_productos   = workbook.add_worksheet('Productos')
	worksheet_bebidas 	  = workbook.add_worksheet('Bebidas')

	# Escribir titulos de caracteristicas de producto/bebida en fichero xlsx
	row  = int(0) 
	col  = int(0)
	for i in range(0, len(str_columnas)):
		worksheet_productos.write (row, col, str_columnas[i])
		worksheet_bebidas.write   (row, col, str_columnas[i])
		col += 1

	# Obtener la lista de productos y bebidas del menu
	# dic_compra = {
	# 	"bebidas": {id: cantidad, 5: 2, 4:1}, 
	# 	"productos": {id: Magnitud(Cantidad+Unidad), 2: Peso(g=2), 5: Volumen(ml=34), 7: Unidad(u=2)}
	# }
	dic_compra 	  = menuToListCompra(id_menu)
	dic_productos = dic_compra['productos']
	dic_bebidas   = dic_compra['bebidas']

	# Volcar productos del menu en formato xlxs
	row = int(0)
	col = int(0)
	for id_producto in dic_productos:
		id_producto = str(id_producto)

		# Obtener el nombre del producto, la unidad de compra, el precio de compra por unidad y el precio de venta por unidad
		calculadora.cursor.execute("SELECT * FROM Producto WHERE id=" + id_producto)
		dic_Producto = queryToDictionary(calculadora.cursor)[0]

		dic_printProducto['Nombre'] 				=   str(dic_Producto['nombre'])
		dic_printProducto['UnidadCompra'] 			=   str(dic_Producto['unidad'])
		dic_printProducto['Cantidad'] 				= float(getattr(dic_productos[id_producto],dic_printProducto['UnidadCompra'])) # expresar cantidad en receta como cantidad de compra
		dic_printProducto['PrecioCompra/Unidad'] 	= float(dic_Producto['precio_unitario'])
		dic_printProducto['PrecioVenta/Unidad']		= float(dic_Producto['precio_total'])

		# Calcular coste y beneficio del producto en el menu
		dic_printProducto['Coste'] 					= float(dic_printProducto['Cantidad'] * dic_printProducto['PrecioCompra/Unidad'])
		dic_printProducto['BeneficioBruto']  		= float(dic_printProducto['Cantidad'] * dic_printProducto['PrecioVenta/Unidad'])
		dic_printProducto['BeneficioNeto']			= float(dic_printProducto['BeneficioBruto'] - dic_printProducto['Coste'])

		row += int(1)
		col  = int(0)
		for columna in str_columnas:
			worksheet_productos.write(row, col, dic_printProducto[columna])
			col += 1

	# Volcar bebidas del menu en formato xlxs
	row = int(0)
	col = int(0)
	for id_bebida in dic_bebidas:
		id_bebida = str(id_bebida)

		# Obtener el nombre de la bebida, la unidad de compra, el precio de compra por unidad y el precio de venta por unidad
		calculadora.cursor.execute("SELECT * FROM Bebida WHERE id=" + id_bebida)
		dic_Bebida = queryToDictionary(calculadora.cursor)[0]

		dic_printProducto['Nombre'] 				=   str(dic_Bebida['nombre'])
		dic_printProducto['UnidadCompra'] 			= 'unidad'
		dic_printProducto['Cantidad'] 				= float(getattr(dic_bebidas[id_bebida],dic_printProducto['UnidadCompra'])) 
		dic_printProducto['PrecioCompra/Unidad'] 	= float(dic_Bebida['precio_unitario'])
		dic_printProducto['PrecioVenta/Unidad']		= float(dic_Bebida['precio_total'])

		# Calcular coste y beneficio de la bebida en el menu
		dic_printProducto['Coste'] 					= float(dic_printProducto['Cantidad'] * dic_printProducto['PrecioCompra/Unidad'])
		dic_printProducto['BeneficioBruto']  		= float(dic_printProducto['Cantidad'] * dic_printProducto['PrecioVenta/Unidad'])
		dic_printProducto['BeneficioNeto']			= float(dic_printProducto['BeneficioBruto'] - dic_printProducto['Coste'])

		row += int(1)
		col  = int(0)
		for columna in str_columnas:
			worksheet_bebidas.write(row, col, dic_printProducto[columna])
			col += 1

	# Cerrar fichero xlsx
	workbook.close()


	




# Receta: Atun al amontillado
# Nombre 	Cantidad 	UnidadCompra	PrecioCompra/Unidad 	PrecioVenta/Unidad 		Coste 			Beneficio
# Solomillo  0.45 		kg 				2.0 					3.0 					Cantidad*PCU 	Cantidad*PVU
def recetaToExcel (id_receta: int, str_nombreFichero: str="receta.xlsx"):
	id_receta 		  = str(id_receta)
	str_nombreFichero = str(str_nombreFichero)

	# Nombre de la receta y columnas de caracteristicas de cada producto
	calculadora.cursor.execute("SELECT nombre FROM Receta WHERE id=" + id_receta)
	str_nombreReceta  = str(queryToDictionary(calculadora.cursor)[0]['nombre'])
	#str_titulo 	 	  = str("Receta: " + str_nombreReceta)
	str_columnas 	  = ['Nombre', 'Cantidad', 'UnidadCompra', 'PrecioCompra/Unidad', 'PrecioVenta/Unidad', 'Coste', 'BeneficioBruto', 'BeneficioNeto']
	dic_printProducto = dict ( zip (str_columnas, [None]*len(str_columnas)))

	# Abrir documento XLSX
	workbook  = xlsxwriter.Workbook(str_nombreFichero)
	worksheet_nombreReceta  = workbook.add_worksheet(str_nombreReceta)
	worksheet 				= workbook.add_worksheet('Productos')

	# Escribir titulo de la receta en fichero xlsx
	#row = int(0)
	#col = int(0)
	#worksheet.write(row, col, str_titulo)
	
	# Escribir titulos de caracteristicas de ingredientes en fichero xlsx
	row  = int(0) #+= int(1)
	col  = int(0)
	for i in range(0, len(str_columnas)):
		worksheet.write (row, col, str_columnas[i])
		col += 1

	# Obtener la lista de productos de la receta
	# dic_productos = {id_producto: Magnitud(unidad=cantidad), 5: Peso(g=1000.0), 1: Unidad(u=12.0), 7: Volumen(l=1.0)}
	dic_productos = recetaToListProductos(id_receta)

	# row = 0
	# col = len(str_columnas)
	# Volcar productos de la receta en formato xlxs
	for id_producto in dic_productos:
		id_producto = str(id_producto)

		# Obtener el nombre del producto, la unidad de compra, el precio de compra por unidad y el precio de venta por unidad
		calculadora.cursor.execute("SELECT * FROM Producto WHERE id=" + id_producto)
		dic_Producto = queryToDictionary(calculadora.cursor)[0]

		dic_printProducto['Nombre'] 				=   str(dic_Producto['nombre'])
		dic_printProducto['UnidadCompra'] 			=   str(dic_Producto['unidad'])
		dic_printProducto['Cantidad'] 				= float(getattr(dic_productos[id_producto],dic_printProducto['UnidadCompra'])) # expresar cantidad en receta como cantidad de compra
		dic_printProducto['PrecioCompra/Unidad'] 	= float(dic_Producto['precio_unitario'])
		dic_printProducto['PrecioVenta/Unidad']		= float(dic_Producto['precio_total'])

		# Calcular coste y beneficio del producto en la receta
		dic_printProducto['Coste'] 					= float(dic_printProducto['Cantidad'] * dic_printProducto['PrecioCompra/Unidad'])
		dic_printProducto['BeneficioBruto']  		= float(dic_printProducto['Cantidad'] * dic_printProducto['PrecioVenta/Unidad'])
		dic_printProducto['BeneficioNeto']			= float(dic_printProducto['BeneficioBruto'] - dic_printProducto['Coste'])
		
		row += int(1)
		col  = int(0)
		for columna in str_columnas:
			worksheet.write(row, col, dic_printProducto[columna])
			col += 1

	# Cerrar fichero xlsx
	workbook.close()




# dic_productos = {id_producto: Magnitud(unidad=cantidad), 5: Peso(g=1000.0), 1: Unidad(u=12.0), 7: Volumen(l=1.0)}
def NULLproductosToExcel (dic_productos: dict={}, row: int=0, col:int=0 ):
	workbook  = xlsxwriter.Workbook('operaciones.xlsx')
	worksheet = workbook.add_worksheet('receta')

	init_row = int(copy(row))
	init_col = int(copy(col))

	str_columnas = ['Nombre', 'Cantidad', 'Unidad', 'UnidadCompra', 'Precio/UnidadCompra', 'Precio/UnidadVenta', 'Total']

	row = copy(init_row)
	col = copy(init_col)
	for i in range(0, len(str_columnas)):
		worksheet.write (row, col, str_columnas[i])
		col += 1

	#print(dic_productos['productos'])
	for id_producto in dic_productos: #['productos']:
		calculadora.cursor.execute("SELECT * FROM Producto WHERE id=" + str(id_producto))
		dic_Producto = calculadora.queryToDictionary(calculadora.cursor)[0]
		float_gastos = 0.0
		str_nombre   = str(dic_Producto['nombre'])
		str_unidad 	 = str(dic_Producto['unidad'])
		str_precio_u = str(dic_Producto['precio_unitario'])
		flo_cantidad = getattr(dic_productos[str(id_producto)], str_unidad)
		str_cantidad = str(flo_cantidad)
		float_total  = flo_cantidad * dic_Producto['precio_unitario']
		str_total    = str(float_total)
		float_gastos += float_total


	workbook.close()
	


