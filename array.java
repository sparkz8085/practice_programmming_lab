import java.util.*;
public class array
{
	public static void main(String args[])
	{
		Scanner sc=new Scanner(System.in);
		System.out.println("enter size of a an array: ");
		int size=sc.nextInt();
		int arr[]=new int[size];
		for (int j=0;j<size;j++)
		{
			System.out.println("Enter Value Number "+(j+1));
			arr[j]=sc.nextInt();
		}

		System.out.println("Entered Value ");
		for(int j=0; j<size; j++)
		{
			System.out.print(arr[j]+",");
		}
	}
}
