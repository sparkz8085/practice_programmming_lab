import java.util.*;
public class calc_area
{
	double vol;
	calc_area()
	{
		vol=0.0;
	}
	void Vol(double x)
	{
		vol=x*x*x;
		System.out.println("Volume of Cube is "+vol);
	}
	void Vol(double x, double y, double z)
	{
		vol=(x*y*z);
		System.out.println("Volume of Cuboid is "+vol);
	}
	void Vol(double x, double y)
	{
		vol=(x*x*x*y);
		System.out.println("Volume of Sphere is "+vol);
	}
	public static void main(String args[])
	{
		calc_area obj= new calc_area();
		Scanner sc= new Scanner(System.in);
		System.out.println("Enter\n1 For Cube\n2 For Cuboid\n3 For Sphere");
		int choice=sc.nextInt();
		switch(choice)
		{
			case 1:
				System.out.println("Enter Side : ");
				double s= sc.nextDouble();
				obj.Vol(s);
				break;
			case 2:
				System.out.println("Enter Length, Breadth, Height : ");
				double l= sc.nextDouble();
				double b= sc.nextDouble();
				double h= sc.nextDouble();
				obj.Vol(l,b,h);
				break;
			case 3:
				System.out.println("Enter Radius : ");
				double r= sc.nextDouble();
				obj.Vol(r,(22.0/7.0));
				break;
			default:
				System.out.println("Wrong Choice");
				break;
		}
	}
}
